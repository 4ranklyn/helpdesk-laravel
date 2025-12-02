<?php

namespace App\Filament\Widgets;

use App\Models\Rating;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class CustomerSatisfactionStats extends BaseWidget
{
    protected static ?int $sort = 0; // Urutan paling atas

    protected function getCards(): array
    {
        // 1. CARI KARYAWAN TERBAIK (Rating Tertinggi)
        $bestEmployee = User::whereHas('ratingsReceived')
            ->withAvg('ratingsReceived', 'rating')
            ->orderByDesc('ratings_received_avg_rating')
            ->first();

        // 2. CARI UNIT TERBAIK
        $bestUnit = DB::table('units')
            ->join('users', 'units.id', '=', 'users.unit_id')
            ->join('tickets', 'users.id', '=', 'tickets.responsible_id')
            ->join('ratings', 'tickets.id', '=', 'ratings.ticket_id')
            ->select('units.name', DB::raw('avg(ratings.rating) as avg_rating'))
            ->groupBy('units.id', 'units.name')
            ->orderByDesc('avg_rating')
            ->first();

        // 3. RATA-RATA GLOBAL
        $globalAvg = Rating::avg('rating') ?: 0;

        return [
            // Kartu 1: Karyawan Terbaik
            Card::make('Karyawan Terbaik', $bestEmployee ? $bestEmployee->name : '-')
                ->description($bestEmployee ? "Skor: " . number_format($bestEmployee->ratings_received_avg_rating, 1) . " / 5.0" : 'Belum ada data')
                ->descriptionIcon('heroicon-s-star') // Pakai icon Star agar aman
                ->color('success'),

            // Kartu 2: Unit Terbaik
            Card::make('Unit Terbaik', $bestUnit ? $bestUnit->name : '-')
                ->description($bestUnit ? "Rata-rata: " . number_format($bestUnit->avg_rating, 1) : 'Belum ada data')
                ->descriptionIcon('heroicon-s-office-building')
                ->color('primary'),

            // Kartu 3: CSAT Global
            Card::make('Total Kepuasan (CSAT)', number_format($globalAvg, 1) . ' / 5.0')
                ->description('Dari seluruh tiket selesai')
                ->color('warning'),
        ];
    }
}
