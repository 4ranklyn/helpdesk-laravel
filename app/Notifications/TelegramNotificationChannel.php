<?php

namespace App\Notifications\Channels;

use App\Notifications\telemed;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class TelegramNotificationChannel
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable The entity being notified.
     * @param  telemed  $notification
     * @return void
     */
    public function send($notifiable, telemed $notification)
    {
        $message = $notification->toTelegram($notifiable);

        // Dapatkan telegram_group_id dari notifiable (dalam kasus ini adalah model Unit)
        $chatId = $notifiable->telegram_group_id;

        if (!$chatId) {
            Log::warning('Telegram group ID not found for notifiable unit: ' . $notifiable->name);
            return;
        }

        $this->telegramService->sendMessage($chatId, $message);
    }
}
