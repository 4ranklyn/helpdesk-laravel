<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Notifications\telemed;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification 
{
    public function handle(TicketCreated $event)
    {
        $ticket = $event->ticket;
        $unit = $ticket->unit;

        // Log untuk debugging
        Log::info('SendTelegramNotification listener triggered for ticket ID: ' . $ticket->id);

        if ($unit && $unit->telegram_group_id) {
            Log::info('Found telegram_group_id: ' . $unit->telegram_group_id . ' for unit: ' . $unit->name);
            
            try {
                // Kirim notifikasi ke Unit. Laravel akan otomatis menggunakan routeNotificationForTelegram.
                $unit->notify(new telemed($ticket));
                Log::info('Successfully sent Telegram notification for ticket ID: ' . $ticket->id);
            } catch (\Exception $e) {
                Log::error('Failed to send Telegram notification for ticket ID: ' . $ticket->id . '. Error: ' . $e->getMessage());
            }

        } else {
            Log::warning('Telegram group ID not found for unit: ' . ($unit ? $unit->name : 'N/A') . ' on ticket ID: ' . $ticket->id);
        }
    }
}
