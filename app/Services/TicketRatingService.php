<?php

namespace App\Services;

use App\Models\Rating;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\DB;

class TicketRatingService
{
    public function rateTicket(Ticket $ticket, int $rating, ?string $comment, int $userId): Rating
    {
        return DB::transaction(function () use ($ticket, $rating, $comment, $userId) {
            // Create the rating
            $rating = Rating::create([
                'ticket_id' => $ticket->id,
                'user_id' => $userId,
                'rating' => $rating,
                'comment' => $comment,
            ]);

            // Update ticket status to resolved
            $ticket->update([
                'ticket_statuses_id' => TicketStatus::RESOLVED
            ]);

            return $rating;
        });
    }
}
