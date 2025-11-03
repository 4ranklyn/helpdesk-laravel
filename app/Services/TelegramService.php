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

    public function sendMessage($chatId, $text)
    {
        return Http::post("{$this->baseUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown', // Tambahkan ini agar format bold (*...*) berfungsi
        ])->json();
    }

    public function setWebhook($url)
    {
        return Http::withOptions([
            'verify' => false,
        ])->post("https://api.telegram.org/bot{$this->token}/setWebhook", [
            'url' => $url,
        ])->json();
    }
}
