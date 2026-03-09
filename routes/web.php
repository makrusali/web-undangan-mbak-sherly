<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvitationSettingController;
use App\Http\Controllers\WeddingEventController;
use App\Http\Controllers\WishController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [InvitationController::class, 'index'])->name('invitation');
Route::get('/for-guest/{guest}', [InvitationController::class, 'guest'])->name('invitation.guest');
Route::get('/api/wishes', [InvitationController::class, 'getWishes'])->name('api.wishes');
Route::post('/api/wishes', [InvitationController::class, 'storeWish'])->name('api.wishes.store');

Route::get("panel/login", [AuthController::class, 'index'])->name('panel.index');
Route::post("panel/login", [AuthController::class, 'store'])->name('panel.login');
Route::post("panel/logout", [AuthController::class, 'logout'])->name('panel.logout');

Route::middleware(AuthMiddleware::class)->prefix("panel")->name('panel.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('guests/template', [GuestController::class, 'downloadTemplate'])->name('guests.template');
    Route::post('guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::resource('guests', GuestController::class);

    Route::get('galleries', [GalleryController::class, 'index'])->name('galleries.index');
    Route::post('galleries/upload', [GalleryController::class, 'upload'])->name('galleries.upload');
    Route::post('galleries/update-order', [GalleryController::class, 'updateOrder'])->name('galleries.update-order');
    Route::delete('galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

    Route::resource('gifts', GiftController::class);
    Route::put('gifts/{gift}/toggle-active', [GiftController::class, 'toggleActive'])->name('gifts.toggle-active');

    Route::resource('wishes', WishController::class)->except(['create']);
    Route::put('wishes/{wish}/approve', [WishController::class, 'approve'])->name('wishes.approve');
    Route::put('wishes/{wish}/reject', [WishController::class, 'reject'])->name('wishes.reject');
    Route::post('wishes/bulk-delete', [WishController::class, 'bulkDelete'])->name('wishes.bulk-delete');
    Route::post('wishes/bulk-approve', [WishController::class, 'bulkApprove'])->name('wishes.bulk-approve');

    Route::resource('wedding-events', WeddingEventController::class);
    Route::put('wedding-events/{weddingEvent}/toggle-active', [WeddingEventController::class, 'toggleActive'])->name('wedding-events.toggle-active');
    Route::post('wedding-events/update-order', [WeddingEventController::class, 'updateOrder'])->name('wedding-events.update-order');

    Route::get('invitation-settings', [InvitationSettingController::class, 'index'])->name('invitation-settings.index');
    Route::put('invitation-settings', [InvitationSettingController::class, 'update'])->name('invitation-settings.update');
    Route::delete('invitation-settings/delete-hero', [InvitationSettingController::class, 'deleteHeroImage'])->name('invitation-settings.delete-hero');
    Route::delete('invitation-settings/delete-groom', [InvitationSettingController::class, 'deleteGroomPhoto'])->name('invitation-settings.delete-groom');
    Route::delete('invitation-settings/delete-bride', [InvitationSettingController::class, 'deleteBridePhoto'])->name('invitation-settings.delete-bride');
    Route::delete('invitation-settings/delete-couple', [InvitationSettingController::class, 'deleteCouplePhoto'])->name('invitation-settings.delete-couple');
    Route::delete('invitation-settings/delete-song', [InvitationSettingController::class, 'deleteSongFile'])->name('invitation-settings.delete-song');
});
