<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class AssignedTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        $user = auth()->user();

        // For both Admin Unit and Staff Unit, show only tickets assigned to them
        return $query->where('responsible_id', $user->id);
    }

    protected function getTitle(): string
    {
        return 'Assigned Tickets';
    }
}
