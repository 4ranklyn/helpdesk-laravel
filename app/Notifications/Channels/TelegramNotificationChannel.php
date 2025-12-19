<?php

namespace App\Notifications\Channels;

use App\Services\TelegramService;
use Illuminate\Notifications\Notification;
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
     * @param  Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the telegram message from the notification
        $message = $notification->toTelegram($notifiable);

        // Dapatkan telegram_group_id dari notifiable (dalam kasus ini adalah model Unit)
        $chatId = $notifiable->telegram_group_id;

        if (!$chatId) {
            Log::warning('Telegram group ID not found for notifiable unit: ' . $notifiable->name);
            return;
        }

        try {
            $response = $this->telegramService->sendMessage($chatId, $message);
            Log::info('Telegram message sent successfully', ['chat_id' => $chatId, 'response' => $response]);
        } catch (\Exception $e) {
            Log::error('Failed to send Telegram message: ' . $e->getMessage());
            throw $e;
        }
    }
}

