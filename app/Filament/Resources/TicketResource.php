<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers\CommentsRelationManager;
use App\Models\Priority;
use App\Models\ProblemCategory;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\Unit;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $isStaffUnit = $user->hasRole('Staff Unit');
        $isAdminUnit = $user->hasRole('Admin Unit');
        
        // Default to not restricted (for create)
        $isRestrictedUser = false;
        
        // Check if we're in edit mode by looking at the current route
        $route = request()->route();
        if ($route && in_array($route->getAction('as'), ['filament.resources.tickets.edit', 'filament.resources.tickets.view'])) {
            $isRestrictedUser = $isStaffUnit || $isAdminUnit;
        }
        
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\Select::make('unit_id')
                        ->label(__('Work Unit'))
                        ->options(Unit::all()
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->disabled($isRestrictedUser)
                        ->afterStateUpdated(function ($state, callable $get, callable $set) use ($isRestrictedUser) {
                            if ($isRestrictedUser) return;
                            
                            $unit = Unit::find($state);
                            if ($unit) {
                                $problemCategoryId = (int) $get('problem_category_id');
                                if ($problemCategoryId && $problemCategory = ProblemCategory::find($problemCategoryId)) {
                                    if ($problemCategory->unit_id !== $unit->id) {
                                        $set('problem_category_id', null);
                                    }
                                }
                            }
                        })
                        ->reactive(),

                    Forms\Components\Select::make('problem_category_id')
                        ->label(__('Problem Category'))
                        ->options(function (callable $get) {
                            $unitId = $get('unit_id');
                            if ($unitId) {
                                return ProblemCategory::where('unit_id', $unitId)->pluck('name', 'id');
                            }
                            return ProblemCategory::all()->pluck('name', 'id');
                        })
                        ->searchable()
                        ->nullable()
                        ->hiddenOn('create')
                        ->disabled($isStaffUnit)  // Only disable for Staff Unit, not Admin Unit
                        ->hint('Set by unit admin')
                        ->visible(fn () => auth()->user()->hasAnyRole(['Super Admin', 'Admin Unit', 'Staff Unit'])),

                    Forms\Components\TextInput::make('title')
                        ->label(__('Title'))
                        ->required()
                        ->maxLength(255)
                        ->disabled($isRestrictedUser)
                        ->columnSpan([
                            'sm' => 2,
                        ]),

                    Forms\Components\RichEditor::make('description')
                        ->label(__('Description'))
                        ->required()
                        ->maxLength(65535)
                        ->disabled($isRestrictedUser)
                        ->columnSpan([
                            'sm' => 2,
                        ]),

                    Forms\Components\Placeholder::make('approved_at')
                        ->translateLabel()
                        ->hiddenOn('create')
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record->approved_at ? $record->approved_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('solved_at')
                        ->translateLabel()
                        ->hiddenOn('create')
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record->solved_at ? $record->solved_at->diffForHumans() : '-'),
                ])->columns([
                    'sm' => 2,
                ])->columnSpan(2),

                Card::make()->schema([
                    Forms\Components\Select::make('priority_id')
                        ->label(__('Priority'))
                        ->options(Priority::all()
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->nullable()
                        ->hiddenOn('create')
                        ->disabled($isStaffUnit && $isRestrictedUser) // Only Staff Unit can't edit priority when editing
                        ->hint('Set by unit admin'),

                    Forms\Components\Select::make('ticket_statuses_id')
                        ->label(__('Status'))
                        ->options(TicketStatus::all()
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->default(TicketStatus::OPEN)
                        ->dehydrateStateUsing(fn ($state) => $state ?? TicketStatus::OPEN)
                        ->hiddenOn('create')
                        ->hidden(
                            fn () => !auth()
                                ->user()
                                ->hasAnyRole(['Super Admin', 'Admin Unit', 'Staff Unit'])
                        ),

                    Forms\Components\Select::make('responsible_id')
                        ->label(__('Responsible'))
                        ->options(function (callable $get) {
                            $unitId = $get('unit_id');
                            $user = auth()->user();
                            
                            // If no unit selected or user is Super Admin, show all users
                            if (!$unitId || $user->hasRole('Super Admin')) {
                                return User::ByRole()->pluck('name', 'id');
                            }
                            
                            // Show only users from the selected unit
                            return User::where('unit_id', $unitId)
                                ->whereHas('roles', function($q) {
                                    $q->whereIn('name', ['Admin Unit', 'Staff Unit']);
                                })
                                ->pluck('name', 'id');
                        })
                        ->searchable()
                        ->required(fn (callable $get) => $get('unit_id') == auth()->user()->unit_id)
                        ->hiddenOn('create')
                        ->hidden(
                            fn () => !auth()
                                ->user()
                                ->hasAnyRole(['Super Admin', 'Admin Unit'])
                        )
                        ->disabled($isStaffUnit) // Only Staff Unit can't edit responsible
                        ->hint(function (callable $get) {
                            if ($get('unit_id') != auth()->user()->unit_id) {
                                return 'Optional when assigned to another unit';
                            }
                            return null;
                        }),

                    Forms\Components\Placeholder::make('created_at')
                        ->translateLabel()
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record ? $record->created_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('updated_at')
                        ->translateLabel()
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        $isSuperAdmin = auth()->user()->hasRole('Super Admin');
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('problemCategory.name')
                    ->searchable()
                    ->label(__('Problem Category'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ticketStatus.name')
                    ->label(__('Status'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('responsible.name')
                    ->label(__('Assigned To'))
                    ->visible(fn () => $isSuperAdmin || auth()->user()->hasRole('Admin Unit'))
                    ->formatStateUsing(fn ($state) => $state ?: 'Unassigned')
                    ->searchable()
                    ->sortable()
                    ->toggleable($isSuperAdmin),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'my-tickets' => Pages\MyTickets::route('/my-tickets'),
            'assigned-tickets' => Pages\AssignedTickets::route('/assigned-tickets'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

    public static function getNavigationItems(): array
    {
        $user = auth()->user();
        $items = [];

        // Only show All Tickets for Super Admin and Admin Unit
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin Unit')) {
            $items[] = NavigationItem::make()
                ->label('All Tickets')
                ->icon('heroicon-o-ticket')
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.tickets.index'))
                ->url(static::getUrl('index'))
                ->sort(1);
        }

        // Show My Tickets and Assigned Tickets for Admin Unit and Staff Unit
        if ($user->hasAnyRole(['Admin Unit', 'Staff Unit'])) {
            $items[] = NavigationItem::make()
                ->label('My Tickets')
                ->icon('heroicon-o-document-text')
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.tickets.my-tickets'))
                ->url(static::getUrl('my-tickets'))
                ->sort(2);

            $items[] = NavigationItem::make()
                ->label('Assigned Tickets')
                ->icon('heroicon-o-clipboard-list')
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.tickets.assigned-tickets'))
                ->url(static::getUrl('assigned-tickets'))
                ->sort(3);
        }

        return $items;
    }

    /**
     * Display tickets based on each role.
     *
     * If it is a Super Admin, then display all tickets.
     * If it is a Admin Unit, then display tickets based on the tickets they have created and their unit id.
     * If it is a Staff Unit, then display tickets based on the tickets they have created and the tickets assigned to them.
     * If it is a Regular User, then display tickets based on the tickets they have created.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                // Display all tickets to Super Admin
                if (auth()->user()->hasRole('Super Admin')) {
                    return;
                }

                if (auth()->user()->hasRole('Admin Unit')) {
                    $query->where('tickets.unit_id', auth()->user()->unit_id)->orWhere('tickets.owner_id', auth()->id());
                } elseif (auth()->user()->hasRole('Staff Unit')) {
                    $query->where('tickets.responsible_id', auth()->id())->orWhere('tickets.owner_id', auth()->id());
                } else {
                    $query->where('tickets.owner_id', auth()->id());
                }
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tickets');
    }
}
