<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class StaffList extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.pages.staff-list';

    protected static ?string $navigationLabel = 'Daftar Staff';

    protected static ?string $title = 'Daftar Staff';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('Admin Unit');
    }

    protected function getTableQuery(): Builder
    {
        $query = User::query()
            ->whereHas('roles', function($query) {
                $query->where('name', 'Staff Unit');
            })
            ->with('unit');

        // If user is Admin Unit (and not Super Admin), only show staff from their unit
        if (auth()->user()->hasRole('Admin Unit') && !auth()->user()->hasRole('Super Admin')) {
            $query->where('unit_id', auth()->user()->unit_id);
        }

        return $query;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('unit.name')
                ->label('Unit')
                ->sortable(),
            Tables\Columns\BadgeColumn::make('roles.name')
                ->label('Role')
                ->colors([
                    'primary' => 'Admin Unit',
                    'success' => 'Staff Unit',
                ]),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make()
                ->url(fn (User $record): string => route('filament.admin.pages.view-staff', $record))
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
