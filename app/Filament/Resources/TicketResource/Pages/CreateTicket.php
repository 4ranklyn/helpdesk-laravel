<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\CreateRecord;

use App\Events\TicketCreated;

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
        TicketCreated::dispatch($this->record);
    }
}
