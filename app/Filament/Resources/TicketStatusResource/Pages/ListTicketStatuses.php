<?php

namespace App\Filament\Resources\TicketStatusResource\Pages;

use App\Filament\Resources\TicketStatusResource;
use App\Filament\Widgets\TicketStatusPieChart;
use App\Filament\Widgets\UnitTicketProgressBarChart;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTicketStatuses extends ListRecords
{
    protected static string $resource = TicketStatusResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        $widgets = [];

        if (auth()->user()->hasRole('Super Admin')) {
            $widgets[] = UnitTicketProgressBarChart::class;
            $widgets[] = TicketStatusPieChart::class;
        }

        return $widgets;
    }

    protected function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }
}
