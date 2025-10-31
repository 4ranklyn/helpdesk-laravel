<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;
use Filament\Widgets\Widget;
use App\Filament\Widgets\TicketStatusPieChart;
use App\Filament\Widgets\UnitTicketProgressBarChart;

class Dashboard extends BasePage
{
    protected function getColumns(): int|string|array
    {
        return 1;
    }

    protected function getWidgets(): array
    {
        $user = auth()->user();
        $widgets = [
            // Common widgets for all roles
            \Filament\Widgets\AccountWidget::class,
            \Awcodes\Overlook\Overlook::class,
        ];

        // Add role-specific widgets
        if ($user->hasRole('Admin Unit')) {
            // Add the pie chart at the bottom for Admin Unit
            $widgets[] = TicketStatusPieChart::class;
        }

        return $widgets;
    }
}
