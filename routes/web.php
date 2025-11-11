<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test-units', function () {
    return response()->json(App\Models\Unit::all());
});

Route::get('/', function () {
    return view('landing');
})->name('home');

// Authentication Routes
require __DIR__.'/auth.php';

Route::post('/telegram/webhook', [TelegramController::class, 'handleWebhook']);

// Socialite login routes
Route::prefix('auth')->group(function () {
    Route::get('/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.provider');
    Route::get('/{provider}/callback', [SocialiteController::class, 'handleProvideCallback'])->name('auth.provider.callback');
});

// Route to handle ticket rating submission
Route::post('/tickets/{ticket}/rate', [\App\Http\Controllers\TicketRatingController::class, 'store'])
    ->name('tickets.rate')
    ->middleware(['auth', 'web']);

// Debug route for checking ticket rating status
Route::get('/debug/ticket/{id}', function($id) {
    $ticket = \App\Models\Ticket::with(['owner', 'responsible', 'ticketStatus', 'rating'])->findOrFail($id);
    
    return response()->json([
        'ticket_id' => $ticket->id,
        'title' => $ticket->title,
        'status' => $ticket->ticketStatus->name,
        'status_id' => $ticket->ticket_statuses_id,
        'owner_id' => $ticket->owner_id,
        'owner_name' => $ticket->owner->name,
        'responsible_id' => $ticket->responsible_id,
        'responsible_name' => $ticket->responsible ? $ticket->responsible->name : null,
        'has_rating' => $ticket->rating ? 'yes' : 'no',
        'current_user_id' => auth()->id(),
        'is_owner' => $ticket->owner_id == auth()->id() ? 'yes' : 'no',
        'can_be_rated' => $ticket->canBeRatedBy(auth()->user()) ? 'yes' : 'no',
        'can_be_rated_debug' => [
            'is_owner' => $ticket->owner_id == auth()->id(),
            'is_pending' => $ticket->ticket_statuses_id == \App\Models\TicketStatus::PENDING_CUSTOMER_RESPONSE,
            'has_no_rating' => !$ticket->rating()->exists()
        ]
    ]);
})->middleware(['auth', 'web']);

// Protected routes (require authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
