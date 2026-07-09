<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/i/{guest:token}', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/i/{guest:token}/rsvp', [InvitationController::class, 'rsvp'])->name('invitation.rsvp');
Route::get('/boda/{wedding}/preview.png', [InvitationController::class, 'ogImage'])->name('invitation.og');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('weddings', WeddingController::class);
    Route::post('weddings/{wedding}/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::post('weddings/{wedding}/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::get('weddings/{wedding}/export', [GuestController::class, 'export'])->name('guests.export');
    Route::delete('guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');

    Route::post('weddings/{wedding}/content', [WeddingController::class, 'updateContent'])->name('weddings.content');
    Route::post('weddings/{wedding}/gallery', [WeddingController::class, 'storeGalleryImages'])->name('weddings.gallery.store');
    Route::delete('weddings/{wedding}/gallery/{file}', [WeddingController::class, 'destroyGalleryImage'])->name('weddings.gallery.destroy');
    Route::post('weddings/{wedding}/music', [WeddingController::class, 'storeMusic'])->name('weddings.music.store');
    Route::delete('weddings/{wedding}/music', [WeddingController::class, 'destroyMusic'])->name('weddings.music.destroy');
});

require __DIR__.'/auth.php';
