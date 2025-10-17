<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification implements ShouldQueue
{
    use InteractsWithQueue;

    protected $telegramService;

    /**
     * Create the event listener.
     *
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
        $ticket = $event->ticket;
        $unit = $ticket->unit;
        $responsibleUser = $ticket->responsible;

        if (!$unit || !$unit->telegram_group_id) {
            Log::info("Ticket {$ticket->id} has no unit or unit has no telegram_group_id.");
            return;
        }

        if (!$responsibleUser || !$responsibleUser->telegram_user_id) {
            Log::info("Ticket {$ticket->id} has no responsible user or user has no telegram_user_id.");
            return;
        }

        $groupId = $unit->telegram_group_id;
        $usernameToMention = $responsibleUser->telegram_username;
        $userIdToMention = $responsibleUser->telegram_user_id;

        $reportTitle = TelegramService::escapeMarkdown($ticket->title);
        $reportUrl = route('filament.resources.tickets.view', $ticket);

        $mention = "[@" . TelegramService::escapeMarkdown($usernameToMention) . "](tg://user?id=" . $userIdToMention . ")";

        $message = "🚨 *Laporan Baru untuk Unit " . TelegramService::escapeMarkdown($unit->name) . "* 🚨\n\n"
                 . "*Judul:* " . $reportTitle . "\n"
                 . "*Prioritas:* " . TelegramService::escapeMarkdown($ticket->priority->name) . "\n\n"
                 . "Mohon untuk segera ditindaklanjuti oleh " . $mention . "\n\n"
                 . "[Lihat Detail Laporan](" . $reportUrl . ")";

        $this->telegramService->sendMessage($groupId, $message, 'MarkdownV2');
    }
}
