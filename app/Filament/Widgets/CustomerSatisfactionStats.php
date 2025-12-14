<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerSatisfactionStats extends BaseWidget
{
    protected static ?int $sort = 0; // Urutan paling atas

    protected function getCards(): array {
        $user = Auth::user();
        $currentPeriod = now()->format('Y-m'); // "2025-12"

        // --- LOGIC A: SUPER ADMIN & MANAJEMEN ---
        if ($user->hasRole(['Super Admin', 'Manajemen Rumah Sakit'])) {
            
            // 1. Overall Best Staff (from Performance Table)
            $bestEmployee = DB::table('staff_performance_scores')
                ->where('period', $currentPeriod)
                ->join('users', 'staff_performance_scores.staff_id', '=', 'users.id')
                ->orderByDesc('saw_score')
                ->select('users.name', 'staff_performance_scores.saw_score')
                ->first();

            // 2. Overall Best Unit (from Performance Table)
            $bestUnit = DB::table('unit_performance_scores')
                ->where('period', $currentPeriod)
                ->join('units', 'unit_performance_scores.unit_id', '=', 'units.id')
                ->orderByDesc('saw_score')
                ->select('units.name', 'unit_performance_scores.saw_score')
                ->first();

            return [
                // Kartu 1: Karyawan Terbaik
                Card::make('Karyawan Terbaik Bulan Ini', $bestEmployee ? $bestEmployee->name : '-')
                    ->description($bestEmployee ? "Skor: " . number_format($bestEmployee->saw_score, 4) : 'Belum ada data')
                    ->icon('heroicon-s-user') // Pakai icon Star agar aman
                    ->color('primary'),

                // Kartu 2: Unit Terbaik
                Card::make('Unit Terbaik Bulan Ini', $bestUnit ? $bestUnit->name : '-')
                    ->description($bestUnit ? "Skor: " . number_format($bestUnit->saw_score, 4) : 'Belum ada data')
                    ->icon('heroicon-s-office-building')
                    ->color('primary')
            ];
        }

        // --- LOGIC B: ADMIN UNIT ---
        if ($user->hasRole('Admin Unit')) {
            $unitId = $user->unit_id;

            // 1. My Unit's Best Staff
            $myBestStaff = DB::table('staff_performance_scores')
                ->join('users', 'staff_performance_scores.staff_id', '=', 'users.id')
                ->where('period', $currentPeriod)
                ->where('users.unit_id', $unitId)
                ->orderByDesc('saw_score')
                ->select('users.name', 'staff_performance_scores.saw_score')
                ->first();

            // 2. My Unit's Performance Score (SAW)
            $myUnitScore = DB::table('unit_performance_scores')
                ->where('period', $currentPeriod)
                ->where('unit_id', $unitId)
                ->value('saw_score');

            // 3. My Unit's Satisfaction Degree (Rating)
            $myAvgRating = DB::table('ratings')
                ->join('tickets', 'ratings.ticket_id', '=', 'tickets.id')
                ->join('users', 'tickets.responsible_id', '=', 'users.id')
                ->where('users.unit_id', $unitId)
                ->whereMonth('tickets.solved_at', now()->month)
                ->whereYear('tickets.solved_at', now()->year)
                ->avg('ratings.rating');

            return [
                // Card 1
                Card::make('Karyawan Terbaik Bulan Ini', $myBestStaff ? $myBestStaff->name : '-')
                    ->description($myBestStaff ? "Skor: " . number_format($myBestStaff->saw_score, 4) : 'Belum ada data')
                    ->icon('heroicon-s-user')
                    ->color('primary'),

                // Card 2: Overall SAW Score (Beside Satisfaction)
                Card::make('Skor Unit Bulan Ini', $myUnitScore ? number_format($myUnitScore, 4) : '-')
                    ->description($myUnitScore ? '' : 'Belum ada data')
                    ->icon('heroicon-o-chart-bar')
                    ->color('primary'),

                // Card 3: Satisfaction
                Card::make('Unit Satisfaction', $myAvgRating ? number_format($myAvgRating, 1) . ' / 5.0' : '-')
                    ->description($myAvgRating ? '' : 'Belum ada data')
                    ->icon('heroicon-s-star')
                    ->color('primary'),
            ];
        }
        return [];
    }
}