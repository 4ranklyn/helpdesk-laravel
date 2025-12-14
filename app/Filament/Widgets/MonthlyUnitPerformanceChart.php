<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;

class MonthlyUnitPerformanceChart extends ApexChartWidget
{
    protected static string $chartId = 'monthlyUnitPerformance';
    protected static ?string $heading = 'Kinerja Bulanan';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    // 1. ADD FILTER (Year Selector)
    protected function getFilters(): ?array
    {
        $currentYear = now()->year;
        return [
            $currentYear => $currentYear,
            $currentYear - 1 => $currentYear - 1,
            $currentYear - 2 => $currentYear - 2,
        ];
    }

    protected function getOptions(): array
    {
        // Get Selected Year (Default to current)
        $year = $this->filter ?? now()->year;
        
        $units = Unit::all();
        $series = [];
        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $months = range(1, 12);

        foreach ($units as $unit) {
            $data = [];
            foreach ($months as $month) {
                $period = sprintf('%04d-%02d', $year, $month);
                
                $score = DB::table('unit_performance_scores')
                    ->where('unit_id', $unit->id)
                    ->where('period', $period)
                    ->value('saw_score');

                $data[] = $score ? round((float)$score, 4) : 0;
            }

            $series[] = [
                'name' => $unit->name,
                'data' => $data,
            ];
        }

        return [
            'chart' => ['type' => 'line', 'height' => 300],
            'series' => $series,
            'xaxis' => [
                'categories' => $categories,
                'labels' => ['style' => ['fontFamily' => 'inherit']],
            ],
            'yaxis' => [
                'title' => ['text' => 'Skor'],
                'min' => 0, 
                'max' => 1,
            ],
            'stroke' => ['curve' => 'smooth', 'width' => 2],
            'colors' => ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'], // Custom colors for different units
        ];
    }
}