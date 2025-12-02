<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;
use App\Filament\Widgets\TicketStatusPieChart;
use App\Filament\Widgets\CustomerSatisfactionStats;
use App\Filament\Widgets\TicketChart;
use App\Filament\Widgets\TopPerformingStaff;

class Dashboard extends BasePage
{
    protected function getColumns(): int|string|array
    {
        return 2;
    }

    protected function getWidgets(): array
    {
        $user = auth()->user();
        $widgets = [];

        // --- URUTAN 1: WELCOME ---
        $widgets[] = \Filament\Widgets\AccountWidget::class;

        // --- URUTAN 2: OVERVIEW (Gambar SS Anda) ---
        $widgets[] = \Awcodes\Overlook\Overlook::class;

        // --- URUTAN 3: DISTRIBUSI STATUS (Pie Chart) ---
        if ($user->hasRole('Admin Unit') || $user->hasRole('Super Admin')) {
            $widgets[] = TicketStatusPieChart::class;
        }

        // --- URUTAN 4 : Leaderboard Staff (Khusus Admin)
        if ($user->hasRole('Admin Unit') || $user->hasRole('Super Admin')) {
            if (class_exists(TopPerformingStaff::class)) {
                $widgets[] = TopPerformingStaff::class;
            }
        }

        // --- URUTAN 5: EXECUTIVE SUMMARY (Rating & Leaderboard) ---
        $widgets[] = CustomerSatisfactionStats::class; // Kartu Angka CSAT
        $widgets[] = TicketChart::class;               // Grafik Tren

        return $widgets;
    }
}
