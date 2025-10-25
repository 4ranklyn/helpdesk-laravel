<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = config('services.telegram-bot-api.token');
        $this->baseUrl = "https://api.telegram.org/bot{$this->token}";
    }

    /**
     * Send a message to a given Telegram chat ID.
     *
     * @param int|string $chatId
     * @param string $message
     * @return bool
     */
    public function sendMessage($chatId, $message)
    {
        if (!$this->token) {
            Log::error('Telegram Bot Token is not configured.');
            return false;
        }

        try {
            $response = Http::post("{$this->baseUrl}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown', // Optional: for rich text formatting
            ]);

            if ($response->failed()) {
                Log::error('Failed to send Telegram message.', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Exception while sending Telegram message.', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
