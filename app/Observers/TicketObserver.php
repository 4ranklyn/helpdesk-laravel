<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\TicketStatus;

class TicketObserver
{
    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        // Check if status was changed
        if ($ticket->isDirty('ticket_statuses_id')) {
            // If status changed to ASSIGNED (2), set approved_at
            if ($ticket->ticket_statuses_id == TicketStatus::ASSIGNED && !$ticket->approved_at) {
                $ticket->approved_at = now();
            }
            
            // If status changed to RESOLVED (6), set solved_at
            if ($ticket->ticket_statuses_id == TicketStatus::RESOLVED && !$ticket->solved_at) {
                $ticket->solved_at = now();
            }
            
            // Save the model again if any timestamps were updated
            if ($ticket->isDirty(['approved_at', 'solved_at'])) {
                $ticket->saveQuietly(); // Use saveQuietly to prevent infinite loop
            }
        }
    }
}
