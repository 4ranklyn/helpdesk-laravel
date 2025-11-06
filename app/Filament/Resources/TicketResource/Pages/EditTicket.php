<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Notifications\TicketCompleted;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $ticket = $this->record;
        $unit = $ticket->unit;

        if ($unit && $unit->telegram_group_id && in_array(strtolower($ticket->ticketStatus->name), ['closed', 'resolved'])) {
            $unit->notify(new TicketCompleted($ticket));
        }
    }
}
