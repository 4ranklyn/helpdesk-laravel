<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use App\Http\Responses\LogoutResponse;
use App\Filament\Resources\TicketResource\Pages\MyTickets;
use App\Filament\Resources\TicketResource\Pages\AssignedTickets;
use App\Filament\Pages\ViewStaff;
use Livewire\Livewire;
use App\Filament\Resources\TicketResource\Pages\Components\RateTicketForm;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(LogoutResponseContract::class, LogoutResponse::class);
        
        // Register Livewire component
        Livewire::component('rate-ticket-form', RateTicketForm::class);

        // Register the view staff page route
        $this->app->booted(function () {
            \Route::get('/admin/view-staff/{record}', ViewStaff::class)
                ->name('filament.admin.pages.view-staff')
                ->middleware('web');
        });
    }
}