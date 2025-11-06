<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Pages\Actions;
use Filament\Resources\Table as ResourceTable;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MyTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->where('owner_id', auth()->id());
    }

    protected function table(ResourceTable $table): ResourceTable
    {
        $table = parent::table($table);
        
        if (auth()->user()->hasRole('Admin Unit')) {
            $table->columns(collect($table->getColumns())->filter(
                fn ($column) => $column->getName() !== 'responsible.name'
            )->toArray());
        }
        
        return $table;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return 'My Tickets';
    }
}
