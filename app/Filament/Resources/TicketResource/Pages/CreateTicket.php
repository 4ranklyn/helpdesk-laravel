<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Notifications\telemed;
use Filament\Resources\Pages\CreateRecord;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    /**
     * Lengkapi data sebelum disimpan ke database.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['owner_id'] = auth()->id();
        $data['ticket_statuses_id'] = 1;

        return $data;
    }

    /**
     * Dispatch the event after the record has been created.
     */
    protected function afterCreate(): void
    {
        $ticket = $this->record;
        $unit = $ticket->unit;

        // Kirim notifikasi ke unit yang bersangkutan
        if ($unit && $unit->telegram_group_id) {
            $unit->notify(new telemed($ticket));
        }
    }
}
