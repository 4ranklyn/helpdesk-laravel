<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PerformanceCalculator;
use App\Services\AhpWeightService;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class RecomputeMonthlyRankings extends Command
{
    protected $signature = 'rankings:recompute {--year=} {--month=}';
    protected $description = 'Recompute monthly staff & unit rankings';

    public function handle(PerformanceCalculator $pc, AhpWeightService $ahpService)
    {
        $year = (int)($this->option('year') ?? now()->year);
        $month = (int)($this->option('month') ?? now()->month);
        $period = sprintf('%04d-%02d', $year, $month);

        $this->info("Recomputing rankings for {$period} ...");

        // 1. GET CACHED WEIGHTS
        $weights = $ahpService->getWeights();

        // 2. STAFF CALCULATION
        $staff = User::role(['Admin Unit', 'Staff Unit'])
        ->with(['ticketResponsibility' => fn($q) => $q->whereNotNull('solved_at')])
        ->get();

        $staffRows = $pc->aggregateStaffForMonth($staff, $year, $month);
        $staffResults = $pc->computeSawScores($staffRows, $weights, array_keys($weights));

        DB::transaction(function() use ($staffResults, $period) {
            foreach ($staffResults as $r) {
                DB::table('staff_performance_scores')->updateOrInsert(
                    ['staff_id' => $r['staff_id'], 'period' => $period],
                    [
                        'tickets_received' => $r['tickets_received'],
                        'tickets_solved'   => $r['tickets_solved'],
                        'solved_ratio' => $r['solved_ratio'],
                        'avg_sla_score' => $r['avg_sla_score'],
                        'avg_rating' => $r['avg_rating'],
                        'saw_score' => $r['saw_score'],
                        'rank' => $r['rank'],
                        'updated_at' => now(),
                    ]
                );
            }
        });

        // 3. UNIT CALCULATION
        $units = Unit::all();
        $unitData = [];
        foreach ($units as $unit) {
            // Ambil semua staff di unit ini berdasarkan role + unit_id
            $staffIds = User::role(['Admin Unit', 'Staff Unit'])
                ->where('unit_id', $unit->id)
                ->pluck('id')
                ->toArray();

            $unitData[] = [
                'unit_id' => $unit->id,
                'unit_name' => $unit->name,
                'staff_ids' => $staffIds,
            ];
        }
        $unitRows = $pc->aggregateUnitForMonth($unitData, $year, $month);
        $unitResults = $pc->computeSawScores($unitRows, $weights, array_keys($weights));

        DB::transaction(function() use ($unitResults, $period) {
            foreach ($unitResults as $r) {
                DB::table('unit_performance_scores')->updateOrInsert(
                    ['unit_id' => $r['unit_id'], 'period' => $period],
                    [
                        'tickets_received' => $r['tickets_received'],
                        'tickets_solved'   => $r['tickets_solved'],
                        'solved_ratio' => $r['solved_ratio'],
                        'avg_sla_score' => $r['avg_sla_score'],
                        'avg_rating' => $r['avg_rating'],
                        'saw_score' => $r['saw_score'],
                        'rank' => $r['rank'],
                        'updated_at' => now(),
                    ]
                );
            }
        });

        $this->info("Rankings computed & saved for {$period}.");
    }
}