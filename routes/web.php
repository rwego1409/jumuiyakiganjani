<?php

use App\Http\Controllers\Admin\ContributionsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\ResourcesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Members\DashboardController as MembersDashboardController;
use App\Http\Controllers\Members\MemberController;
use App\Http\Controllers\Members\ResourceController;
use App\Http\Controllers\Members\BalanceController;
use App\Http\Controllers\Members\TransactionController;
use App\Http\Controllers\Members\ContributionController as MemberContributionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController; // ADDED MISSING IMPORT
use App\Http\Controllers\ClickPesaController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Breeze's default authentication routes
require __DIR__.'/auth.php'; 

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['admin'])
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Admin Settings
            Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

            // Admin Courses
            Route::resource('courses', CourseController::class);

            // Admin Activities
            Route::get('/activities', [ActivityController::class, 'index'])->name('activities');

            // Admin Members
            Route::resource('members', MembersController::class);

            // Admin Contributions
            Route::resource('contributions', ContributionsController::class);

            // Admin Events
            Route::resource('events', EventsController::class);

            // Admin Resources
            Route::resource('resources', ResourcesController::class);

            // Admin Reports
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/', [ReportsController::class, 'index'])->name('index');
                Route::get('/generate/{type}/{format?}', [ReportsController::class, 'generate'])
                    ->name('generate')
                    ->where([
                        'type' => 'contributions|members',
                        'format' => 'pdf|excel|csv'
                    ]);
                Route::post('/download', [ReportsController::class, 'download'])->name('download');
            });

            // Export Route for Reports
            Route::get('/reports/export/{id}/{format}', [ReportsController::class, 'export'])->name('reports.export');

            // Schedule reminder route
            Route::post('/contributions/{contribution}/schedule-reminder', [ContributionsController::class, 'scheduleReminder'])
                ->name('contributions.scheduleReminder');
        });
    
    // Member routes
    Route::prefix('member')
        ->name('member.')
        ->middleware(['member'])
        ->group(function () {
            // Member Dashboard
            Route::get('/dashboard', [MembersDashboardController::class, 'index'])->name('dashboard');

            // Member Contributions
            Route::prefix('contributions')->name('contributions.')->group(function () {
                Route::get('/', [MemberContributionController::class, 'index'])->name('index');
                Route::get('/create', [MemberContributionController::class, 'create'])->name('create');
                Route::post('/', [MemberContributionController::class, 'store'])->name('store');
                Route::get('/{contribution}', [MemberContributionController::class, 'show'])->name('show');
                Route::get('/{contribution}/receipt', [MemberContributionController::class, 'downloadReceipt'])->name('receipt');
            });

            // Member Resources
            Route::prefix('resources')->name('resources.')->group(function () {
                Route::get('/', [ResourceController::class, 'index'])->name('index');
                Route::get('/{resource}', [ResourceController::class, 'show'])->name('show');
                Route::get('/{resource}/download', [ResourceController::class, 'download'])->name('download');
            });

            // Member Payments
            Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
            Route::get('/payments/success/{payment}', [PaymentController::class, 'success'])->name('payments.success');

            // Member Events
            Route::prefix('events')->name('events.')->group(function () {
                Route::get('/', [MemberController::class, 'indexEvents'])->name('index');
                Route::get('/{event}', [MemberController::class, 'showEvent'])->name('show');
                Route::post('/{event}/attend', [MemberController::class, 'attendEvent'])->name('attend');
                Route::get('/{event}/confirmation', [MemberController::class, 'eventConfirmation'])->name('confirmation');
            });

            // Member Activities
            Route::prefix('activities')->name('activities.')->group(function () {
                Route::get('/', [MemberController::class, 'indexActivities'])->name('index');
                Route::get('/{activity}', [MemberController::class, 'showActivity'])->name('show');
            });
        });

    // Profile Management routes
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::patch('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    });

    // Notifications routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });

    // M-Pesa payment routes
    Route::prefix('mpesa')->name('mpesa.')->group(function () {
        Route::post('/payment', [PaymentController::class, 'initiatePayment'])->name('payment');
        Route::post('/callback', [MpesaController::class, 'callback'])->name('callback');
    });

    // ClickPesa payment routes
    Route::prefix('clickpesa')->name('clickpesa.')->group(function () {
        Route::post('/payment', [ClickPesaController::class, 'initiate'])->name('payment');
        Route::post('/callback', [ClickPesaController::class, 'callback'])->name('callback');
    });

    // Test M-Pesa token route (for testing only)
    Route::post('/test-mpesa-token', function () {
        $mpesaService = app(App\Services\MpesaService::class);
        $result = $mpesaService->testWithDirectToken();
        
        return response()->json($result);
    });

Route::put('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');


Route::get('/send-test-email', function () {
    Mail::raw('This is a test email sent via Mailtrap.', function ($message) {
        $message->to('ludovickpancras@gmail.com')->subject('Test Email');
    });
    
    return 'Test email sent!';
});

    // Fallback route
    Route::fallback(function () {
        return view('errors.404');
    });
});
