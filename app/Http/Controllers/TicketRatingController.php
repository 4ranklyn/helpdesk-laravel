<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketRatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketRatingController extends Controller
{
    protected $ratingService;

    public function __construct(TicketRatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function store(Request $request, Ticket $ticket)
    {
        try {
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);

            // Check if the user can rate this ticket
            if (!$ticket->canBeRatedBy(auth()->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to rate this ticket.'
                ], 403);
            }

            // Submit the rating
            $this->ratingService->rateTicket(
                $ticket,
                $validated['rating'],
                $validated['comment'] ?? '',
                auth()->id()
            );

            return response()->json([
                'success' => true,
                'message' => 'Rating submitted successfully.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error submitting rating: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your rating.'
            ], 500);
        }
    }
}
