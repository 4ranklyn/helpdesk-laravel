<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;

class YearlyPerformanceTrendChart extends ApexChartWidget
{
    protected static string $chartId = 'yearlyPerformanceTrend';
    protected static ?string $heading = 'Perbandingan Kinerja Unit Tahun ke Tahun';
    protected static ?int $sort = 3; 
    protected int | string | array $columnSpan = 'full';

    protected function getOptions(): array
    {
        // 1. [DYNAMIC] Get all unique years available in the database
        $years = DB::table('unit_performance_scores')
            ->pluck('period')
            ->map(fn ($period) => (int) substr($period, 0, 4))
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Fallback: If DB is empty, just show the current year
        if (empty($years)) {
            $years = [now()->year];
        }

        // Optional: Ensure current year is always included
        if (!in_array(now()->year, $years)) {
            $years[] = now()->year;
            sort($years);
        }

        $units = Unit::all();
        $series = [];

        // 2. Build Data for each Unit
        foreach ($units as $unit) {
            $data = [];
            foreach ($years as $year) {
                $avgScore = DB::table('unit_performance_scores')
                    ->where('unit_id', $unit->id)
                    ->where('period', 'like', "$year-%")
                    ->avg('saw_score');

                $data[] = $avgScore ? round((float)$avgScore, 4) : 0;
            }

            $series[] = [
                'name' => $unit->name,
                'data' => $data,
            ];
        }

        return [
            'chart' => [
                'type' => 'line', // Changed to Line
                'height' => 350,
                'toolbar' => ['show' => false],
            ],
            // Removed 'plotOptions' (Bar settings)
            'series' => $series,
            'xaxis' => [
                'categories' => $years,
                'labels' => ['style' => ['fontFamily' => 'inherit']],
                // 'title' => ['text' => 'Year'],
            ],
            'yaxis' => [
                'title' => ['text' => 'Skor Rata-rata'],
                'min' => 0, 
                'max' => 1,
            ],
            'colors' => ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
            'stroke' => [
                'curve' => 'smooth', // Makes the line wavy/smooth
                'width' => 3,        // Line thickness
            ],
            'markers' => [           // Adds dots at data points
                'size' => 5,
                'hover' => ['size' => 7],
            ],
            'legend' => [
                'position' => 'bottom'
            ],
        ];
    }
}