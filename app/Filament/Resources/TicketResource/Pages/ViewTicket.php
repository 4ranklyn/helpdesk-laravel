<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
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
        return [
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
    }
}
