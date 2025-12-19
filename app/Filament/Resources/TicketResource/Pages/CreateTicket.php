<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Notifications\telemed;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

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
            try {
                $unit->notify(new telemed($ticket));
                Log::info("Telegram notification sent for ticket #{$ticket->id} to unit {$unit->name}");
            } catch (\Exception $e) {
                Log::error("Failed to send Telegram notification for ticket #{$ticket->id}: " . $e->getMessage());
            }
        }
    }
}

