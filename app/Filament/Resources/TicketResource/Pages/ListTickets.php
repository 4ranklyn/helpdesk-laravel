<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();
        $user = auth()->user();

        // Super Admin can see all tickets
        if ($user->hasRole('Super Admin')) {
            return $query;
        }
        
        // Admin Unit can see all tickets in their unit
        if ($user->hasRole('Admin Unit')) {
            return $query->where('unit_id', $user->unit_id);
        }
        
        // For other roles, only see their own tickets
        return $query->where('owner_id', $user->id);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return 'All Tickets';
    }

    protected function getTableColumns(): array
    {
        $columns = parent::getTableColumns();
        
        // Add responsible column for Super Admin
        if (auth()->user()->hasRole('Super Admin')) {
            $columns = array_merge(
                array_slice($columns, 0, 3, true),
                ['responsible.name' => Tables\Columns\TextColumn::make('responsible.name')
                    ->label('Assigned To')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ?: 'Unassigned')],
                array_slice($columns, 3, null, true)
            );
        }
        
        return $columns;
    }
}
