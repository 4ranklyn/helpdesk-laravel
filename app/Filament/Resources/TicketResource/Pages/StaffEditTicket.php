<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\TicketStatus;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\Auth;

class StaffEditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Select::make('ticket_statuses_id')
                        ->label(__('Status'))
                        ->options(TicketStatus::all()->pluck('name', 'id'))
                        ->required(),
                ])
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Only return the status field to be edited
        return [
            'ticket_statuses_id' => $data['ticket_statuses_id'] ?? null,
        ];
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Only update the status field
        $record->update([
            'ticket_statuses_id' => $data['ticket_statuses_id'],
        ]);
        
        return $record;
    }

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->hidden(fn () => !auth()->user()->hasRole('Super Admin')),
        ];
    }

    protected function getTitle(): string
    {
        return __('Update Ticket Status');
    }

    protected function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        return [
            $resource::getUrl() => $resource::getBreadcrumb(),
            $this->record->title => $resource::getUrl('view', ['record' => $this->record]),
            $this->getBreadcrumb(),
        ];
    }
}
