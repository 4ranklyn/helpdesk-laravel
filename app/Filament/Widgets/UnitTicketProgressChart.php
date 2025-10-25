<?php

namespace App\Filament\Widgets;

use App\Models\Unit;
use Filament\Widgets\BarChartWidget;

class UnitTicketProgressChart extends BarChartWidget
{
    protected static ?string $heading = 'Progress Tiket per Unit';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '350px';

    protected function getData(): array
    {
        $units = Unit::withCount([
            'tickets as total_tickets',
            'tickets as completed_tickets' => function($query) {
                $query->whereHas('ticketStatus', function($q) {
                    $q->whereIn('name', ['closed', 'resolved']);
                });
            },
            'tickets as pending_tickets' => function($query) {
                $query->whereHas('ticketStatus', function($q) {
                    $q->whereNotIn('name', ['closed', 'resolved']);
                });
            }
        ])->get();

        $labels = $units->pluck('name')->toArray();
        $completed = $units->pluck('completed_tickets')->toArray();
        $pending = $units->pluck('pending_tickets')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Tiket Selesai (Closed/Resolved)',
                    'data' => $completed,
                    'backgroundColor' => '#4CAF50',
                    'borderColor' => '#388E3C',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Tiket Belum Selesai',
                    'data' => $pending,
                    'backgroundColor' => '#FF9800',
                    'borderColor' => '#F57C00',
                    'borderWidth' => 1,
                ]
            ],
            'labels' => $labels,
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'stacked' => true,
                        'ticks' => [
                            'stepSize' => 1,
                            'precision' => 0
                        ],
                        'title' => [
                            'display' => true,
                            'text' => 'Jumlah Tiket'
                        ]
                    ],
                    'x' => [
                        'stacked' => true,
                        'title' => [
                            'display' => true,
                            'text' => 'Unit'
                        ]
                    ]
                ],
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'top',
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Progress Penyelesaian Tiket per Unit',
                        'font' => [
                            'size' => 16
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Super Admin');
    }
}
