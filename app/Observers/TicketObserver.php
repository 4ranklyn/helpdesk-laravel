<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Notifications\TicketStatusUpdated;
use Illuminate\Support\Facades\Log;

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
            
            if ($ticket->isDirty(['approved_at', 'solved_at'])) {
                $ticket->saveQuietly(); // Use saveQuietly to prevent infinite loop
            }

            // Check if status requires notification to sender (Owner's Unit)
            $targetStatuses = [
                TicketStatus::IN_PROGRESS,
                TicketStatus::ON_HOLD,
                TicketStatus::PENDING_CUSTOMER_RESPONSE,
                TicketStatus::RESOLVED,
            ];

            if (in_array($ticket->ticket_statuses_id, $targetStatuses)) {
                $owner = $ticket->owner;
                $ownerUnit = $owner ? $owner->unit : null;

                if ($ownerUnit && $ownerUnit->telegram_group_id) {
                    try {
                        $ownerUnit->notify(new TicketStatusUpdated($ticket));
                        Log::info("TicketStatusUpdated notification sent to Unit ID: {$ownerUnit->id} for Ticket ID: {$ticket->id}");
                    } catch (\Exception $e) {
                        Log::error("Failed to send TicketStatusUpdated notification. Ticket ID: {$ticket->id}. Error: " . $e->getMessage());
                    }
                }
            }
        }
    }
}
