<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopPerformingStaff extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Top 5 Teknisi Terbaik';

    // Matikan pagination agar tampilan ringkas (hanya list)
    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->whereHas('ratingsReceived')
            ->withAvg('ratingsReceived', 'rating')
            ->withCount('responsibleTickets')
            ->orderByDesc('ratings_received_avg_rating')
            ->take(5); // Hanya ambil 5 orang
    }

    protected function getTableColumns(): array
    {
        return [
            // KOLOM 1: NAMA & UNIT (Digabung agar rapi)
            Tables\Columns\TextColumn::make('name')
                ->label('Nama Teknisi')
                ->weight('bold')
                // Menampilkan Unit di bawah nama (warna abu-abu kecil)
                ->description(fn (User $record): string => $record->unit ? $record->unit->name : '-'),

            // KOLOM 2: RATING
            Tables\Columns\TextColumn::make('ratings_received_avg_rating')
                ->label('Rating')
                ->formatStateUsing(fn ($state) => number_format((float)$state, 1) . ' ⭐')
                ->color(fn ($state) => $state >= 4.5 ? 'success' : ($state >= 3 ? 'warning' : 'danger'))
                ->sortable(),

            // KOLOM 3: TOTAL TIKET
            Tables\Columns\TextColumn::make('responsible_tickets_count')
                ->label('Tiket Selesai')
                ->alignCenter()
                ->color('secondary'),
        ];
    }
}
