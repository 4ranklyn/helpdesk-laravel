<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class TelegramSetWebhook extends Command
{
    protected $signature = 'telegram:set-webhook';

    protected $description = 'Set the Telegram webhook URL';

    public function handle(TelegramService $telegramService)
    {
        $webhookUrl = config('telegram.webhook_url');

        if (!$webhookUrl) {
            $this->error('TELEGRAM_WEBHOOK_URL is not set in your .env file.');
            return 1;
        }

        if ($webhookUrl === 'YOUR-TELEGRAM-WEBHOOK-URL') {
            $this->error('TELEGRAM_WEBHOOK_URL is set to the default placeholder value.');
            $this->info('Please update it in your .env file with a valid public URL (e.g., from ngrok).');
            return 1;
        }

        $response = $telegramService->setWebhook($webhookUrl);

        if ($response['ok']) {
            $this->info('Telegram webhook set successfully!');
            $this->line('URL: ' . $webhookUrl);
        } else {
            $this->error('Failed to set Telegram webhook.');
            $this->line('Error: ' . $response['description']);
        }

        return 0;
    }
}