<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\EventController;
use App\Models\Campaign;
use App\Http\Controllers\Admin\CalendarCampaignController;
use App\Http\Controllers\Admin\CalendarCategoryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicDonationController;
use App\Http\Controllers\UserCalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportController;

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

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Public Donation Routes
Route::get('/donation', [PublicDonationController::class, 'index'])->name('donation');
Route::post('/donation', [PublicDonationController::class, 'store'])->name('donation.store');
Route::get('/donation/success', [PublicDonationController::class, 'success'])->name('donation.success');

// Monetary Donation Routes
Route::get('/monetary-donation', [PublicDonationController::class, 'monetaryDonation'])->name('monetary_donation');
Route::post('/monetary-donation', [PublicDonationController::class, 'submitMonetaryDonation'])->name('monetary_donation.submit');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login']);
});

// Admin Protected Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Logout route
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Events
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('events/json', [EventController::class, 'getEventsJson'])->name('events.json');
        Route::get('events/upcoming', [EventController::class, 'getUpcomingEvents'])->name('events.upcoming');
        
        // Categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names([
            'index' => 'categories.index',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'show' => 'categories.show',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'destroy' => 'categories.destroy'
        ]);

        // Donations
        Route::get('donations', [\App\Http\Controllers\Admin\DonationController::class, 'index'])->name('donations.index');
        Route::get('donations/dropoffs', [\App\Http\Controllers\Admin\DonationController::class, 'dropoffs'])->name('donations.dropoffs');
        Route::get('donations/pending', [\App\Http\Controllers\Admin\DonationController::class, 'pending'])->name('donations.pending');
        Route::get('donations/reports', [\App\Http\Controllers\Admin\DonationController::class, 'reports'])->name('donations.reports');
        Route::get('donations/all-donors', [\App\Http\Controllers\Admin\DonationController::class, 'allDonors'])->name('donations.all-donors');
        Route::get('donations/{donation}', [\App\Http\Controllers\Admin\DonationController::class, 'show'])->name('donations.show');
        Route::get('donations/{donation}/edit', [\App\Http\Controllers\Admin\DonationController::class, 'edit'])->name('donations.edit');
        Route::put('donations/{donation}', [\App\Http\Controllers\Admin\DonationController::class, 'update'])->name('donations.update');
        Route::delete('donations/{donation}', [\App\Http\Controllers\Admin\DonationController::class, 'destroy'])->name('donations.destroy');
        Route::patch('donations/{donation}/status', [\App\Http\Controllers\Admin\DonationController::class, 'updateStatus'])->name('donations.update-status');
        
        
        // Calendar Routes
        Route::get('/calendar', [\App\Http\Controllers\Admin\CalendarController::class, 'index'])->name('calendar.index');
        Route::post('/calendar', [\App\Http\Controllers\Admin\CalendarController::class, 'store'])->name('calendar.store');
        Route::put('/calendar/{campaign}', [\App\Http\Controllers\Admin\CalendarController::class, 'update'])->name('calendar.update');
        Route::delete('/calendar/{campaign}', [\App\Http\Controllers\Admin\CalendarController::class, 'destroy'])->name('calendar.destroy');

        // Volunteers
        Route::get('volunteers', [AdminController::class, 'volunteerIndex'])->name('volunteers.index');
        Route::post('volunteers/{volunteer}/approve', [AdminController::class, 'approveVolunteer'])->name('volunteers.approve');
        Route::post('volunteers/{volunteer}/reject', [AdminController::class, 'rejectVolunteer'])->name('volunteers.reject');

        // Students
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::post('students/{tracking_code}/approve', [StudentController::class, 'approve'])->name('students.approve');
        Route::post('students/{tracking_code}/reject', [StudentController::class, 'reject'])->name('students.reject');
        Route::delete('students/{tracking_code}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::delete('students/user/{id}', [StudentController::class, 'destroyUser'])->name('students.destroyUser');

        // Campaigns
        Route::get('campaigns/dashboard', [CampaignController::class, 'dashboard'])->name('campaigns.dashboard');
        Route::resource('campaigns', \App\Http\Controllers\Admin\CampaignController::class)->names([
            'index' => 'campaigns.index',
            'create' => 'campaigns.create',
            'store' => 'campaigns.store',
            'show' => 'campaigns.show',
            'edit' => 'campaigns.edit',
            'update' => 'campaigns.update',
            'destroy' => 'campaigns.destroy',
        ]);
        Route::patch('campaigns/{campaign}/status', [CampaignController::class, 'updateStatus'])->name('campaigns.update-status');

        // Urgent Campaigns
        Route::get('urgent-campaigns', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'index'])->name('urgent-campaigns.index');
        Route::get('urgent-campaigns/create', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'create'])->name('urgent-campaigns.create');
        Route::post('urgent-campaigns', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'store'])->name('urgent-campaigns.store');
        Route::get('urgent-campaigns/{urgent_campaign}', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'show'])->name('urgent-campaigns.show');
        Route::get('urgent-campaigns/{urgent_campaign}/edit', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'edit'])->name('urgent-campaigns.edit');
        Route::put('urgent-campaigns/{urgent_campaign}', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'update'])->name('urgent-campaigns.update');
        Route::delete('urgent-campaigns/{urgent_campaign}', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'destroy'])->name('urgent-campaigns.destroy');
        Route::patch('urgent-campaigns/{urgent_campaign}/status', [\App\Http\Controllers\Admin\UrgentCampaignController::class, 'updateStatus'])->name('urgent-campaigns.update-status');

        // Reports Routes
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/monetary', [\App\Http\Controllers\Admin\ReportController::class, 'monetary'])->name('reports.monetary');
        Route::get('/reports/non-monetary', [\App\Http\Controllers\Admin\ReportController::class, 'nonMonetary'])->name('reports.non-monetary');
        Route::get('/reports/donors', [\App\Http\Controllers\Admin\ReportController::class, 'donors'])->name('reports.donors');
        Route::get('/reports/campaigns', [\App\Http\Controllers\Admin\ReportController::class, 'campaigns'])->name('reports.campaigns');

        // Calendar Campaign Routes
        Route::get('calendar-campaigns/create', [\App\Http\Controllers\Admin\CalendarCampaignController::class, 'create'])->name('calendar-campaigns.create');
        Route::post('calendar-campaigns', [\App\Http\Controllers\Admin\CalendarCampaignController::class, 'store'])->name('calendar-campaigns.store');
        
        // Calendar Categories Routes
        Route::resource('calendar-categories', \App\Http\Controllers\Admin\CalendarCategoryController::class);

        // Campaigns Categories Routes
        Route::resource('campaigns-categories', App\Http\Controllers\Admin\CategoryController::class);
    });
});

// Job Routes (both public and admin)
Route::middleware(['auth'])->group(function () {
    // Public/volunteer job routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/listings', [JobController::class, 'listings'])->name('jobs.listings');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::post('/jobs/{job}/approve', [JobController::class, 'approve'])->name('jobs.approve');
    Route::post('/jobs/{job}/reject', [JobController::class, 'reject'])->name('jobs.reject');
});

// Admin Job Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('jobs', [\App\Http\Controllers\Admin\JobListingController::class, 'index'])->name('jobs.index');
    Route::get('jobs/create', [\App\Http\Controllers\Admin\JobListingController::class, 'create'])->name('jobs.create');
    Route::post('jobs', [\App\Http\Controllers\Admin\JobListingController::class, 'store'])->name('jobs.store');
    Route::get('jobs/{job}', [\App\Http\Controllers\Admin\JobListingController::class, 'show'])->name('jobs.show');
    Route::get('jobs/{job}/edit', [\App\Http\Controllers\Admin\JobListingController::class, 'edit'])->name('jobs.edit');
    Route::put('jobs/{job}', [\App\Http\Controllers\Admin\JobListingController::class, 'update'])->name('jobs.update');
    Route::delete('jobs/{job}', [\App\Http\Controllers\Admin\JobListingController::class, 'destroy'])->name('jobs.destroy');
});

// Scholarship Routes
Route::group(['prefix' => 'scholarship'], function () {
    Route::get('/apply', [ScholarshipController::class, 'showApplyForm'])->name('scholarship.apply.form');
    Route::post('/apply', [ScholarshipController::class, 'apply'])->name('scholarship.apply');
    Route::get('/status/{tracking_code}', [ScholarshipController::class, 'show'])->name('scholarship.show');
    Route::match(['get', 'post'], '/scholarship/track', [App\Http\Controllers\ScholarshipController::class, 'track'])->name('scholarship.track');
    // Resend tracking code by email
    Route::post('/resend', [ScholarshipController::class, 'resendCode'])->name('scholarship.resend');
});

// Student routes
Route::middleware(['auth', \App\Http\Middleware\RedirectIfNotStudent::class])->prefix('student')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
});

// Other routes...

// Dashboard and User Management routes without auth
Route::middleware(['auth'])->group(function () {
    // Add a redirect route for /dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isStudent()) {
            return redirect()->route('student.dashboard');
        } elseif (auth()->user()->isVolunteer()) {
            return redirect()->route('volunteer.dashboard');
        } else {
            // If user has no specific role, redirect to home or show an error
            return redirect()->route('welcome')->with('error', 'You do not have access to any dashboard.');
        }
    })->name('dashboard');
});

// User management routes with auth
Route::middleware(['auth'])->group(function () {
    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // User Calendar Routes
    Route::get('/calendar', [UserCalendarController::class, 'index'])->name('user.calendar');
    Route::get('/calendar/events', [UserCalendarController::class, 'getEvents'])->name('user.calendar.events');

    // New routes for volunteer dashboard and job post
    Route::get('/volunteer/job-post', [VolunteerController::class, 'jobPost'])->name('volunteer.job-post');
    // Route to handle volunteer job post submission
    Route::post('/volunteer/job-post', [VolunteerController::class, 'storeJobPost'])->name('volunteer.jobs.store');
});
// Event routes with auth
Route::middleware(['auth'])->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/json', [EventController::class, 'getEventsJson'])->name('events.json');
    Route::get('/events/upcoming', [EventController::class, 'getUpcomingEvents'])->name('events.upcoming');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

// Student Applications Route with auth
Route::middleware(['auth'])->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
});

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/applications', [ScholarshipController::class, 'index'])->name('admin.applications.index');
    Route::post('/applications/{id}/status', [ScholarshipController::class, 'updateStatus'])->name('admin.applications.updateStatus');
    // Student management
    Route::get('/students', [App\Http\Controllers\Admin\StudentController::class, 'index'])
        ->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
        ->name('admin.students.index.shortcut');
    Route::post('/students/{tracking_code}/approve', [App\Http\Controllers\Admin\StudentController::class, 'approve'])->name('admin.students.approve');
    Route::post('/students/{tracking_code}/reject', [App\Http\Controllers\Admin\StudentController::class, 'reject'])->name('admin.students.reject');
});