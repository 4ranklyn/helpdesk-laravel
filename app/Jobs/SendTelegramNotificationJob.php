<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticket;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     */
    public function handle(TelegramService $telegramService): void
    {
        $unit = $this->ticket->unit;
        if ($unit && $unit->telegram_group_id) {
            $message = "New ticket created:\n";
            $message .= "Title: {$this->ticket->title}\n";
            $message .= "Description: {$this->ticket->description}\n";
            $message .= "Unit: {$unit->name}\n";
            $message .= "Author: {$this->ticket->user->name}";

            $telegramService->sendMessage($unit->telegram_group_id, $message);
        }
    }
}