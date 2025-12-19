<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class TelegramTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:test {chat_id : The Telegram chat ID or group ID to send to} {--message= : Optional custom message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending a message via Telegram bot';

    /**
     * Execute the console command.
     */
    public function handle(TelegramService $telegramService): int
    {
        $chatId = $this->argument('chat_id');
        $message = $this->option('message') ?? "🔔 *Test Notification*\n\nThis is a test message from your Helpdesk Laravel application.\n\n✅ Telegram bot is working correctly!";

        $this->info("Sending message to chat ID: {$chatId}");
        
        try {
            $response = $telegramService->sendMessage($chatId, $message);
            
            if (isset($response['ok']) && $response['ok'] === true) {
                $this->info('✅ Message sent successfully!');
                $this->line('Response: ' . json_encode($response, JSON_PRETTY_PRINT));
                return Command::SUCCESS;
            } else {
                $this->error('❌ Failed to send message.');
                $this->line('Response: ' . json_encode($response, JSON_PRETTY_PRINT));
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
