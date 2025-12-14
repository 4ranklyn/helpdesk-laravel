<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class UnitAnnualSummaryTable extends Widget
{
    protected static string $view = 'filament.widgets.unit-annual-summary-table';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    // 1. Property to store the selected year
    public $selectedYear;

    public function mount()
    {
        // Default to current year
        $this->selectedYear = now()->year;
    }

    protected function getViewData(): array
    {
        $units = Unit::all();
        $reportData = [];

        foreach ($units as $unit) {
            $avgScore = DB::table('unit_performance_scores')
                ->where('unit_id', $unit->id)
                ->where('period', 'like', "{$this->selectedYear}-%")
                ->avg('saw_score');

            // Logic for Status
            $status = 'Belum ada data';
            $color = 'text-gray-500 bg-gray-100';
            if ($avgScore) {
                if ($avgScore >= 0.8) {
                    $status = 'Sangat Baik';
                    $color = 'text-green-700 bg-green-100';
                } elseif ($avgScore >= 0.6) {
                    $status = 'Baik';
                    $color = 'text-orange-700 bg-orange-100';
                } else {
                    $status = 'Perlu Peninngkatan';
                    $color = 'text-red-700 bg-red-100';
                }
            }

            $reportData[] = [
                'name' => $unit->name,
                'raw_score' => $avgScore ?? 0, // Store raw float for sorting
                'avg_score' => $avgScore ? number_format($avgScore, 4) : '-',
                'status' => $status,
                'status_color' => $color,
            ];
        }

        // [FIX] Sort by 'raw_score' descending (Highest first)
        usort($reportData, fn($a, $b) => $b['raw_score'] <=> $a['raw_score']);

        return [
            'reportData' => $reportData,
            'years' => range(now()->year, now()->year - 2),
        ];
    }
}