<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeading(): string
    {
        return $this->record->title;
    }

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
