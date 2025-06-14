<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\PublicDonationController;
use App\Http\Controllers\AdminController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Add the DELETE route for volunteers
Route::delete('/volunteers/{volunteer}', [VolunteerController::class, 'destroy']);

Route::put('/donations/{donation}/preference', [PublicDonationController::class, 'updateDonationPreference']);

// New route for real-time donation statistics
Route::middleware(['auth:sanctum', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/donation-stats', [AdminController::class, 'getDonationStats']);
});
