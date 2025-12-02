<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;

class TicketChart extends ApexChartWidget
{
    protected static string $chartId = 'ticketsPerDayChart';
    protected static ?string $heading = 'Grafik Tiket Masuk (30 Hari Terakhir)';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getOptions(): array
    {
        // 1. Ambil Data (Jumlah Tiket per Hari)
        $data = Trend::model(Ticket::class)
            ->between(
                start: Carbon::now()->subDays(30),
                end: Carbon::now(),
            )
            ->perDay()
            ->count();

        // 2. Format Data
        $categories = $data->map(fn (TrendValue $value) => $value->date);
        $values = $data->map(fn (TrendValue $value) => $value->aggregate);

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
                'toolbar' => ['show' => false],
            ],
            'series' => [
                [
                    'name' => 'Tiket Masuk',
                    'data' => $values,
                ],
            ],
            'xaxis' => [
                'categories' => $categories,
                'labels' => [
                    'style' => ['fontFamily' => 'inherit'],
                ],
                // Label Bawah
                // 'title' => [
                //     'text' => 'Tanggal',
                //     'style' => ['fontWeight' => 600],
                // ],
            ],
            'yaxis' => [
                // --- PENGATURAN SKALA 0 - 200 ---
                'min' => 0,
                'max' => 200, // Batas atas 200
                'tickAmount' => 5, // Agar interval angkanya rapi (0, 40, 80, dst)

                // 'labels' => [
                //     'formatter' => 'function (value) { return value.toFixed(0); }',
                // ],
                // Label Kiri
                'title' => [
                    'text' => 'Jumlah Tiket', // <--- Ganti jadi Jumlah Tiket
                    'style' => ['fontWeight' => 600],
                ],
            ],
            'colors' => ['#3B82F6'],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 3,
            ],
        ];
    }
}
