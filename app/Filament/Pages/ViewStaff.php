<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Ticket;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\ViewEntry;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ViewStaff extends Page
{
    protected static string $view = 'filament.pages.view-staff';
    protected static ?string $title = 'Staff Details';
    
    public ?array $data = [];
    public User $staff;
    public $completedTicketsCount;
    public $ongoingTicketsCount;
    public $averageRating;
    public $totalRatings;

    public function mount(User $record): void
    {
        $this->staff = $record->load('unit');
        $this->form->fill($record->toArray());
        
        // Get ticket statistics
        // Count of tickets assigned to this staff member that are still in progress
        $this->ongoingTicketsCount = \App\Models\Ticket::where('responsible_id', $this->staff->id)
            ->whereIn('ticket_statuses_id', [1, 2, 3]) // Open, Assigned, In Progress
            ->count();
            
        // Count of tickets that this staff member has resolved
        $this->completedTicketsCount = \App\Models\Ticket::where('responsible_id', $this->staff->id)
            ->where('ticket_statuses_id', 6) // Resolved status
            ->count();
            
        // Calculate average rating and total ratings from resolved tickets
        $ratings = \App\Models\Rating::selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
            ->whereHas('ticket', function($query) {
                $query->where('responsible_id', $this->staff->id)
                      ->where('ticket_statuses_id', 6); // Only count ratings from resolved tickets
            })
            ->first();
            
        $this->averageRating = $ratings ? round($ratings->avg_rating, 1) : 0;
        $this->totalRatings = $ratings ? $ratings->total : 0;
    }
    
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.pages.daftar-staff') => 'Daftar Staff',
            '' => $this->staff->name,
        ];
    }
    
    public function getViewData(): array
    {
        return [
            'ongoingTickets' => $this->staff->tickets()
                ->with(['ticketStatus', 'problemCategory', 'priority'])
                ->whereIn('ticket_statuses_id', [1, 2])
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Staff Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email')
                            ->disabled(),
                        TextInput::make('unit.name')
                            ->label('Unit')
                            ->disabled(),
                        TextInput::make('identity')
                            ->label('Nomor Identitas')
                            ->disabled(),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->disabled(),
                    ])
                    ->columns(2),
                
                Section::make('Statistik Tiket')
                    ->schema([
                        \Filament\Forms\Components\View::make('stats')
                            ->view('filament.components.staff-stats', [
                                'completedTickets' => $this->completedTicketsCount,
                                'ongoingTickets' => $this->ongoingTicketsCount,
                            ]),
                    ]),
                
                Section::make('Tiket Berlangsung')
                    ->schema([
                        \Filament\Forms\Components\View::make('ongoing-tickets')
                            ->view('filament.components.staff-ongoing-tickets', [
                                'tickets' => $this->staff->tickets()
                                    ->with(['ticketStatus', 'problemCategory'])
                                    ->whereIn('ticket_statuses_id', [1, 2])
                                    ->latest()
                                    ->limit(5)
                                    ->get()
                            ]),
                    ])
                    ->collapsible(),
                
                Section::make('Tiket Selesai')
                    ->schema([
                        \Filament\Forms\Components\View::make('completed-tickets')
                            ->view('filament.components.staff-completed-tickets', [
                                'tickets' => $this->staff->tickets()
                                    ->with(['ticketStatus', 'problemCategory'])
                                    ->where('ticket_statuses_id', 3)
                                    ->latest()
                                    ->limit(5)
                                    ->get()
                            ]),
                    ])
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    protected function getFormModel(): string 
    {
        return User::class;
    }

    public static function getNavigationLabel(): string
    {
        return 'Detail Staff';
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
