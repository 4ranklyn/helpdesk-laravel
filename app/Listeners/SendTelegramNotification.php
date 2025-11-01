<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Jobs\SendTelegramNotificationJob;

class SendTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event): void
    {
        SendTelegramNotificationJob::dispatch($event->ticket);
    }
}