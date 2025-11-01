<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Services\TelegramService;

use Illuminate\Support\Facades\Log; // Tambahkan ini

class SendTelegramNotification 
{

    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function handle(TicketCreated $event)
    {
        $ticket = $event->ticket;
        $unit = $ticket->unit;

        // Log untuk debugging
        Log::info('SendTelegramNotification listener triggered for ticket ID: ' . $ticket->id);

        if ($unit && $unit->telegram_group_id) {
            // Log bahwa group ID ditemukan
            Log::info('Found telegram_group_id: ' . $unit->telegram_group_id . ' for unit: ' . $unit->name);

            $message = "🔔 *Tiket Baru Dibuat* 🔔\n\n" .
                       "*Judul:* " . $ticket->title . "\n" .
                       "*Unit:* " . $unit->name . "\n" .
                       "*Prioritas:* " . $ticket->priority->name . "\n" .
                       "*Oleh:* " . $ticket->owner->name . "\n\n" .
                       "Silakan periksa detailnya di aplikasi Helpdesk.";

            try {
                $this->telegramService->sendMessage($unit->telegram_group_id, $message);
                Log::info('Successfully sent Telegram notification for ticket ID: ' . $ticket->id);
            } catch (\Exception $e) {
                // Log jika terjadi error saat mengirim
                Log::error('Failed to send Telegram notification for ticket ID: ' . $ticket->id . '. Error: ' . $e->getMessage());
            }
        } else {
            // Log jika group ID tidak ditemukan
            Log::warning('Telegram group ID not found for unit: ' . ($unit ? $unit->name : 'N/A') . ' on ticket ID: ' . $ticket->id);
        }
    }
}
