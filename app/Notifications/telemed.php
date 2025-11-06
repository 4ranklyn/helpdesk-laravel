<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

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
        // Gunakan channel dari library laravel-notification-channels/telegram
        return [TelegramChannel::class];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Telegram\TelegramMessage
     */
    public function toTelegram($notifiable): TelegramMessage
    {
        return TelegramMessage::create()
            ->content("🔔 *Tiket Baru Dibuat* 🔔\n")
            ->line("*Judul:* " . $this->ticket->title)
            ->line("*Unit:* " . $notifiable->name)
            ->line("*Prioritas:* " . $this->ticket->priority->name)
            ->line("*Oleh:* " . $this->ticket->owner->name)
            ->line("\nSilakan periksa detailnya di aplikasi Helpdesk.");
    }
}
