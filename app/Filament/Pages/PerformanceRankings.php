<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Pages\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class PerformanceRankings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Performance Rankings';
    protected static ?string $title = 'Staff & Unit Rankings';
    protected static string $view = 'filament.pages.performance-rankings';

    // Properties
    public $staffRanks = [];
    public $unitRanks = [];
    public $selectedYear;
    public $selectedMonth;

    /**
     * SECURITY LAYER 1: 
     * Prevent "Staff Unit" and "No Role" users from seeing this in the sidebar.
     */
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        // Only these 3 roles can see the menu item
        return $user->hasRole(['Manajemen Rumah Sakit', 'Super Admin', 'Admin Unit']);
    }

    public function mount()
    {
        $user = Auth::user();

        // SECURITY LAYER 2: 
        // Abort 403 if a user tries to access the URL directly
        if (! $user->hasRole(['Manajemen Rumah Sakit', 'Super Admin', 'Admin Unit'])) {
            abort(403, 'Unauthorized access.');
        }

        $this->selectedYear = now()->year;
        $this->selectedMonth = now()->month;
        $this->loadData();
    }

    public function loadData()
    {
        $user = Auth::user();
        $period = sprintf('%04d-%02d', $this->selectedYear, $this->selectedMonth);

        // --- REALITY CHECK: LAZY LOADING ---
        // 1. Check if rankings exist for this specific month
        $exists = DB::table('staff_performance_scores')
            ->where('period', $period)
            ->exists();

        // 2. If NO data exists, we check if there are actual tickets to calculate
        // (This prevents calculating empty months like "January 1990")
        if (! $exists) {
            // Check if there are any approved tickets in this month
            $hasTickets = DB::table('tickets')
                ->whereYear('approved_at', $this->selectedYear)
                ->whereMonth('approved_at', $this->selectedMonth)
                ->exists();

            if ($hasTickets) {
                // 3. RUN CALCULATION INSTANTLY
                // This might take 1-2 seconds, but only the FIRST time this month is viewed.
                Artisan::call('rankings:recompute', [
                    '--year' => $this->selectedYear,
                    '--month' => $this->selectedMonth,
                ]);
            }
        }

        // --- QUERY 1: STAFF RANKINGS ---
        $staffQuery = DB::table('staff_performance_scores')
            ->where('period', $period)
            ->join('users', 'staff_performance_scores.staff_id', '=', 'users.id')
            ->select('staff_performance_scores.*', 'users.name as staff_name', 'users.unit_id');

        // SECURITY LAYER 3: Data Filtering
        // If "Admin Unit", force them to see ONLY their unit's staff.
        if ($user->hasRole('Admin Unit')) {
             $staffQuery->where('users.unit_id', $user->unit_id);
        }
        // "Manajemen Rumah Sakit" and "Super Admin" skip the if-block, so they see ALL staff.

        // $this->staffRanks = $staffQuery->orderBy('rank')->get();
        // [FIX] Convert Objects to Arrays here
        $this->staffRanks = $staffQuery->orderBy('rank')
            ->get()
            ->map(fn($item) => (array) $item)
            ->all();

        // --- QUERY 2: UNIT RANKINGS ---
        // Requirement: "Admin unit can see the unit ranks too" -> No filter needed here.
        $this->unitRanks = DB::table('unit_performance_scores')
            ->where('period', $period)
            ->join('units', 'unit_performance_scores.unit_id', '=', 'units.id')
            ->select('unit_performance_scores.*', 'units.name as unit_name')
            ->orderBy('rank')
            ->get()
            ->map(fn($item) => (array) $item) // [FIX] Convert here too
            ->all();;
    }

    protected function getActions(): array
    {
        $actions = [
             // Filter Button (Visible to all authorized users)
             Action::make('filter')
                ->label('Filter Period')
                ->icon('heroicon-o-filter')
                ->form([
                    Select::make('year')
                        ->options(array_combine(range(now()->year - 2, now()->year), range(now()->year - 2, now()->year)))
                        ->default(now()->year),
                    Select::make('month')
                        ->options([
                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                        ])
                        ->default(now()->month),
                ])
                ->action(function (array $data) {
                    $this->selectedYear = $data['year'];
                    $this->selectedMonth = $data['month'];
                    $this->loadData();
                })
        ];

        // Recalculate Button (ONLY for Manajemen/Super Admin)
        // Admin Unit cannot recalculate the whole hospital's scores.
        if (Auth::user()->hasRole(['Manajemen Rumah Sakit', 'Super Admin'])) {
            $actions[] = Action::make('recalculate')
                ->label('Recalculate Ranks')
                ->color('danger')
                ->icon('heroicon-o-refresh')
                ->requiresConfirmation()
                ->action(function () {
                    Artisan::call('rankings:recompute', [
                        '--year' => $this->selectedYear,
                        '--month' => $this->selectedMonth,
                    ]);
                    $this->loadData();
                    Notification::make()->title('Rankings Updated')->success()->send();
                });
        }

        return $actions;
    }
}