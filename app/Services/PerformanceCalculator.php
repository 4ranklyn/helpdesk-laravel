<?php

namespace App\Services;

use App\Models\Priority;
use App\Models\Ticket;

class PerformanceCalculator
{
    /**
     * Compute SLA score with capped bonus (linear)
     *
     * @param int $actualMinutes
     * @param array|Priority $priorityRow
     * @return float
     */
    public function computeSlaScore(int $actualMinutes, $priorityRow): float
    {
        $targetHours = is_array($priorityRow) ? $priorityRow['sla_hours'] : $priorityRow->sla_hours;
        $target = max(1, (int)($targetHours * 60)); // minutes
        $bonusCap = is_array($priorityRow) ? $priorityRow['bonus_cap'] : $priorityRow->bonus_cap;
        $earlyCap = is_array($priorityRow) ? $priorityRow['early_cap'] : $priorityRow->early_cap;

        if ($actualMinutes <= 0) return (float)$bonusCap;
        if ($actualMinutes <= $target) {
            $earlyRatio = ($target - $actualMinutes) / $target;
            $frac = $earlyRatio / max($earlyCap, 1e-9);
            if ($frac > 1) $frac = 1;
            $bonus = $frac * ($bonusCap - 1.0);
            return round(1.0 + $bonus, 6);
        }
        return round($target / $actualMinutes, 6);
    }

    /**
     * Aggregate staff for given period (year, month)
     * @param \Illuminate\Support\Collection $staffCollection
     * @param int $year
     * @param int $month
     * @return array
     */
    public function aggregateStaffForMonth($staffCollection, int $year, int $month): array {
        $priorities = Priority::all()->keyBy('id');
        $rows = [];

        foreach ($staffCollection as $staff) {
            $tickets = $staff->ticketResponsibility ?? collect();
            $ticketsReceived = 0;
            $ticketsSolved = 0;
            $slaScores = [];
            $ratings = [];

            foreach ($tickets as $t) {
                // Ticket counted as RECEIVED if approved this month
                if ($t->approved_at && $t->approved_at->year == $year && $t->approved_at->month == $month) {
                    $ticketsReceived++;
                }

                // Ticket counted as SOLVED if solved this month
                if ($t->solved_at && $t->solved_at->year == $year && $t->solved_at->month == $month) {
                    $ticketsSolved++;
                    $priority = $priorities->get($t->priority_id) ?? (object)[
                        'sla_hours' => 24, 'bonus_cap' => 1.3, 'early_cap' => 0.5, 'is_time_sensitive' => true,
                    ];
                    
                    if ($t->approved_at && $t->solved_at) {
                            $actualMinutes = (int)$t->approved_at->diffInMinutes($t->solved_at);
                            $slaScores[] = $priority->is_time_sensitive ? $this->computeSlaScore($actualMinutes, $priority) : 1.0;
                    }

                    if ($t->rating?->rating) {
                        $ratings[] = (float)$t->rating->rating;
                    }
                }
            }
            $solveRatio = ($ticketsReceived > 0) ? $ticketsSolved / $ticketsReceived : 0;
            $avgSla = count($slaScores) ? array_sum($slaScores) / count($slaScores) : 0.0;
            $avgRating = count($ratings) ? array_sum($ratings) / count($ratings) : 0.0;

            $rows[] = [
                'staff_id'       => $staff->id,
                'staff_name'     => $staff->name,
                'tickets_received' => $ticketsReceived,
                'tickets_solved' => $ticketsSolved,
                'solved_ratio'    => round($solveRatio, 6),  
                'avg_sla_score'  => round($avgSla, 6),
                'avg_rating'     => round($avgRating, 4),
            ];
        }
        return $rows;
    }

    /**
     * Aggregate units for month
     */
    public function aggregateUnitForMonth($unitData, $year, $month) {
        $priorities = Priority::all()->keyBy('id');
        $rows = [];

        foreach ($unitData as $unit) {

            $staffIds = $unit['staff_ids'];

            if (empty($staffIds)) {
                $rows[] = [
                    'unit_id' => $unit['unit_id'],
                    'unit_name' => $unit['unit_name'],
                    'tickets_received' => 0,
                    'tickets_solved' => 0,
                    'solved_ratio' => 0,
                    'avg_sla_score' => 0,
                    'avg_rating' => 0,
                ];
                continue;
            }

            $tickets = Ticket::whereIn('responsible_id', $staffIds)
                ->with('priority', 'rating')
                ->get();

            $received = $tickets->filter(fn($t) =>
                $t->approved_at &&
                $t->approved_at->year == $year &&
                $t->approved_at->month == $month
            );

            $solved = $tickets->filter(fn($t) =>
                $t->solved_at &&
                $t->solved_at->year == $year &&
                $t->solved_at->month == $month
            );

            $ticketsReceived = $received->count();
            $ticketsSolved = $solved->count();

            $solveRatio = ($ticketsReceived > 0) ? $ticketsSolved / $ticketsReceived : 0;

            $slaScores = $solved->map(function ($t) use ($priorities) {
                $priority = $priorities->get($t->priority_id) ?? (object)[
                    'sla_hours' => 24,
                    'bonus_cap' => 1.3,
                    'early_cap' => 0.5,
                    'is_time_sensitive' => true,
                ];

                if (!$t->approved_at || !$t->solved_at) return 0;

                $actualMinutes = $t->approved_at->diffInMinutes($t->solved_at);

                return $this->computeSlaScore($actualMinutes, $priority);
            });

            $avgSla = $slaScores->avg() ?? 0;
            $avgRating = $solved->map(fn($t) => optional($t->rating)->rating ?? 0)->avg() ?? 0;

            $rows[] = [
                'unit_id' => $unit['unit_id'],
                'unit_name' => $unit['unit_name'],
                'tickets_received' => $ticketsReceived,
                'tickets_solved' => $ticketsSolved,
                'solved_ratio' => round($solveRatio, 6),
                'avg_sla_score' => round($avgSla, 6),
                'avg_rating' => round($avgRating, 4),
            ];
        }
        return $rows;
    }

    /**
     * Generic SAW
     * $weights: associative weights e.g. ['tickets_solved'=>0.5, 'avg_sla_score'=>0.3, 'avg_rating'=>0.2]
     * $keysToUse: order of keys to normalize
     */
    public function computeSawScores(array $rows, array $weights, array $keysToUse): array
    {
        $columns = [];
        foreach ($keysToUse as $k) $columns[$k] = array_column($rows, $k);
        $max = [];
        foreach ($columns as $k => $arr) $max[$k] = max($arr) ?: 1;

        $results = [];
        foreach ($rows as $r) {
            $score = 0.0;
            foreach ($keysToUse as $k) {
                $norm = ($r[$k] / $max[$k]);
                $score += ($weights[$k] ?? 0) * $norm;
            }
            $r['saw_score'] = round($score, 6);
            $results[] = $r;
        }

        usort($results, fn($a,$b) => $b['saw_score'] <=> $a['saw_score']);
        $rank = 1;
        foreach ($results as &$res) $res['rank'] = $rank++;

        return $results;
    }
}