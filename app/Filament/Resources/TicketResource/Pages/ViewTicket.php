<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Filament\Resources\TicketResource\Pages\Components\RateTicketForm;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Livewire\Component;

class ViewTicket extends ViewRecord
{
    protected $listeners = ['refreshComponent' => 'refreshComponent'];
    
    public function refreshComponent()
    {
        $this->form->fill();
        $this->reset('form');
    }
    protected static string $resource = TicketResource::class;

    protected function getHeading(): string
    {
        return $this->record->title;
    }

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        $schema = [
            Card::make()
                ->schema([
                    TextInput::make('creator')
                        ->label('Dibuat Oleh')
                        ->formatStateUsing(fn () => $this->record->owner->name)
                        ->disabled()
                        ->columnSpan(1),
                    
                    TextInput::make('owner_unit')
                        ->label('Unit Asal')
                        ->formatStateUsing(fn () => $this->record->owner->unit->name ?? '-')
                        ->disabled()
                        ->columnSpan(1),
                ])
                ->columns(2),
            
            ...parent::getFormSchema(),
        ];

        try {
            // Debug logging
            \Log::info('ViewTicket - Checking if ticket can be rated', [
                'ticket_id' => $this->record->id,
                'owner_id' => $this->record->owner_id,
                'current_user_id' => auth()->id(),
                'ticket_status_id' => $this->record->ticket_statuses_id,
                'has_rating' => $this->record->rating ? 'yes' : 'no',
                'canBeRated' => $this->record->canBeRatedBy(auth()->user()) ? 'yes' : 'no'
            ]);

            // Add rating form if the ticket is in pending customer response status and not yet rated
            if ($this->record->canBeRatedBy(auth()->user())) {
                \Log::info('Adding rating form to ticket view', [
                    'ticket_id' => $this->record->id,
                    'user_id' => auth()->id(),
                    'is_owner' => $this->record->owner_id == auth()->id() ? 'yes' : 'no',
                    'status' => $this->record->ticket_statuses_id,
                    'has_rating' => $this->record->rating ? 'yes' : 'no'
                ]);

                // Add the rating form directly to the schema
                $schema[] = \Filament\Forms\Components\Section::make(__('Rate Your Support Experience'))
                    ->schema([
                        \Filament\Forms\Components\View::make('filament.resources.ticket-resource.pages.components.rate-ticket-form')
                            ->viewData([
                                'ticket' => $this->record,
                                'ticketId' => $this->record->id,
                                'canRate' => true
                            ])
                    ]);
            }
            // Show rating if it exists
            elseif ($this->record->rating) {
                $rating = $this->record->rating;
                $schema[] = \Filament\Forms\Components\Section::make(__('Rating'))
                    ->schema([
                        \Filament\Forms\Components\View::make('filament.resources.ticket-resource.pages.components.rating-display')
                            ->viewData(['rating' => $rating])
                    ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error in ViewTicket form schema: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }

        return $schema;
    }
}
