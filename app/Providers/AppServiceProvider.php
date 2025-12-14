<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use App\Http\Responses\LogoutResponse;
use Livewire\Livewire;
use App\Filament\Resources\TicketResource\Pages\Components\RateTicketForm;
use Filament\Facades\Filament;

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
        Filament::renderHook(
            'styles.after', // Ini akan memuat CSS Anda setelah CSS inti F2
            fn () => view('partials.filament-custom-styles')
        );
    }
}
