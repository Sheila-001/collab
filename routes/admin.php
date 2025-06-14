// Reports Routes
Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
Route::get('/reports/monetary', [ReportController::class, 'monetary'])->name('admin.reports.monetary');
Route::get('/reports/non-monetary', [ReportController::class, 'nonMonetary'])->name('admin.reports.non-monetary');
Route::get('/reports/donors', [ReportController::class, 'donors'])->name('admin.reports.donors');
Route::get('/reports/campaigns', [ReportController::class, 'campaigns'])->name('admin.reports.campaigns');
Route::get('/donations', [DonationController::class, 'index'])->name('admin.donations.index');
Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('admin.donations.show'); 