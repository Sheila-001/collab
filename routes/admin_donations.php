<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DonationController;

Route::get('/test-route', function() {
    return 'Test route is working';
});

Route::match(['put', 'patch'], '/donations/{donation}/status', [DonationController::class, 'updateStatus'])->name('admin.donations.update-status'); 