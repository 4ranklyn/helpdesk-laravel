<?php

namespace App\Filament\Widgets;

use App\Models\TicketStatus;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TicketStatusPieChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'ticketStatusesChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Ticket Status Distribution (Pie Chart)';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $ticketStatuses = TicketStatus::select('id', 'name')->withCount(['tickets'])->get();
        
        return [
            'chart' => [
                'type' => 'pie',
                'height' => 350,
            ],
            'series' => $ticketStatuses->pluck('tickets_count')->toArray(),
            'labels' => $ticketStatuses->pluck('name')->toArray(),
            'legend' => [
                'labels' => [
                    'colors' => '#4B5563',
                    'fontWeight' => 500,
                ],
                'position' => 'bottom',
            ],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size' => '60%',
                    ],
                ],
            ],
            'title' => [
                'text' => 'Distribusi Status Tiket',
                'align' => 'center',
                'style' => [
                    'fontSize' => '16px',
                    'fontWeight' => 'bold',
                ],
            ],
        ];
    }
}
