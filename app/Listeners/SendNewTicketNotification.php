<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewTicketNotification
{
    protected $telegramService;

    /**
     * Create the event listener.
     *
     * @param \App\Services\TelegramService $telegramService
     * @return void
     */
    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TicketCreated  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        $ticket = $event->ticket->load(['unit', 'user']); // Eager load relationships

        if ($ticket->unit && $ticket->unit->telegram_group_id) {
            $message = "📢 *Laporan Tiket Baru*\n\n";
            $message .= "*ID Tiket:* `{$ticket->id}`\n";
            $message .= "*Unit:* {$ticket->unit->name}\n";
            $message .= "*Judul:* {$ticket->title}\n";
            $message .= "*Pelapor:* {$ticket->user->name}\n\n";
            $message .= "Mohon untuk segera ditindaklanjuti.";

            $this->telegramService->sendMessage($ticket->unit->telegram_group_id, $message);
        }
    }
}
