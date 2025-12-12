<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TicketStatusUpdated extends Notification
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
        $statusName = $this->ticket->ticketStatus->name ?? 'Unknown';
        
        return TelegramMessage::create()
            ->content("🔔 *Status Tiket Diperbarui* 🔔\n")
            ->line("*Judul:* " . $this->ticket->title)
            ->line("*Status Baru:* " . $statusName)
            ->line("*Unit Pengirim:* " . ($this->ticket->owner->unit->name ?? '-'))
            ->line("\nSilakan periksa detailnya di aplikasi Helpdesk.");
    }
}
