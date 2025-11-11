<?php

namespace App\Filament\Resources\TicketResource\Pages\Components;

use App\Models\Ticket;
use App\Services\TicketRatingService;
use Livewire\Component;

class RateTicketForm extends Component
{
    public $ticketId;
    public $ticket;
    public int $rating = 5;
    public ?string $comment = '';
    public bool $showSuccess = false;
    public ?string $errorMessage = null;
    public bool $submitting = false;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'refresh' => '$refresh'
    ];
    
    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ];

    public function mount($ticket)
    {
        $this->ticketId = is_object($ticket) ? $ticket->id : $ticket;
        $this->ticket = Ticket::with('rating')->findOrFail($this->ticketId);
        
        // Debug log
        \Log::info('RateTicketForm mounted', [
            'ticket_id' => $this->ticketId,
            'ticket_status' => $this->ticket->ticket_statuses_id,
            'has_rating' => $this->ticket->rating ? 'yes' : 'no'
        ]);
    }

    public function submit(TicketRatingService $ratingService)
    {
        $this->submitting = true;
        $this->resetErrorBag();
        $this->errorMessage = null;
        
        try {
            // Validate the form
            $validated = $this->validate();
            
            // Make sure we have the latest ticket data
            $this->ticket = Ticket::findOrFail($this->ticketId);
            
            // Submit the rating
            $ratingService->rateTicket(
                $this->ticket,
                $validated['rating'],
                $validated['comment'] ?? '',
                auth()->id()
            );

            // Update the UI
            $this->ticket->refresh();
            $this->showSuccess = true;
            
            // Emit events to update the UI
            $this->emit('ratingSubmitted');
            $this->emitTo('filament.pages.ticket-resource.pages.view-ticket', 'refreshComponent');
            
            // Also emit a browser event in case the parent is listening for that
            $this->dispatchBrowserEvent('rating-submitted');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errorMessage = __('Please correct the errors below.');
        } catch (\Exception $e) {
            $this->errorMessage = __('Failed to submit rating. Please try again.');
            \Log::error('Rating submission failed: ' . $e->getMessage());
        } finally {
            $this->submitting = false;
        }
    }

    public function render()
    {
        return view('filament.resources.ticket-resource.pages.components.rate-ticket-form');
    }
}
