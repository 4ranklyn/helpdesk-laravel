<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Notifications\Channels\TelegramNotificationChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class telemed extends Notification
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        // Gunakan custom channel yang menggunakan TelegramService dengan SSL disabled
        return [TelegramNotificationChannel::class];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toTelegram($notifiable): string
    {
        $ownerName = $this->ticket->owner ? $this->ticket->owner->name : 'Unknown';
        
        return "🔔 *Tiket Baru Dibuat* 🔔\n"
            . "*Judul:* " . $this->ticket->title . "\n"
            . "*Unit:* " . $notifiable->name . "\n"
            . "*Oleh:* " . $ownerName . "\n"
            . "\nSilakan periksa detailnya di aplikasi Helpdesk.";
    }
}

