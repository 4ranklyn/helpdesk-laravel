<?php

namespace App\Filament\Widgets;

use App\Models\TicketStatus;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Facades\Auth;

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
    protected static ?string $heading = 'Distribusi Status Tiket Unit Anda';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $user = Auth::user();
        
        // If user is Admin Unit, filter tickets by their unit
        if ($user->hasRole('Admin Unit') && $user->unit_id) {
            $ticketStatuses = TicketStatus::select('id', 'name')
                ->withCount(['tickets' => function($query) use ($user) {
                    $query->where('unit_id', $user->unit_id);
                }])
                ->get();
            
            $title = 'Distribusi Status Tiket Unit ' . ($user->unit->name ?? '');
        } else {
            // For Super Admin, show all tickets
            $ticketStatuses = TicketStatus::select('id', 'name')
                ->withCount('tickets')
                ->get();
                
            $title = 'Distribusi Status Tiket Semua Unit';
        }
        
        // Filter out statuses with zero tickets
        $filteredStatuses = $ticketStatuses->filter(function($status) {
            return $status->tickets_count > 0;
        });
        
        return [
            'chart' => [
                'type' => 'pie',
                'height' => 350,
            ],
            'series' => $filteredStatuses->pluck('tickets_count')->toArray(),
            'labels' => $filteredStatuses->pluck('name')->toArray(),
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
                'text' => $title,
                'align' => 'center',
                'style' => [
                    'fontSize' => '16px',
                    'fontWeight' => 'bold',
                ],
            ],
            'tooltip' => [
                'y' => [
                    'formatter' => 'function(value) { return value + " tiket" }',
                ]
            ]
        ];
    }
}
