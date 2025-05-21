<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    ContributionsController,
    DashboardController as AdminDashboardController,
    EventsController,
    MembersController,
    ResourcesController,
    SettingsController,
    ActivityController,
    ReportsController,
    NotificationController as AdminNotificationController
};
use App\Http\Controllers\Members\{
    DashboardController as MembersDashboardController,
    MemberController,
    ResourceController,
    ContributionController as MemberContributionController
};
use App\Http\Controllers\{
    HomeController,
    ProfileController,
    MpesaController,
    ProfileSetupController,
    PaymentController,
    NotificationController,
    ClickPesaController
};
use App\Models\User;
use App\Notifications\TestNotification;

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Authentication
require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');

    // Admin routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['admin'])
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Settings
            Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
            Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

            // Resources
            Route::resource('resources', ResourcesController::class);
            Route::get('/resources/download', [ResourcesController::class, 'download'])->name('resources.download');

            // Members
            Route::resource('members', MembersController::class);
            Route::get('members/import', [MembersController::class, 'importForm'])->name('members.importForm');
            Route::post('members/import', [MembersController::class, 'import'])->name('members.import');

            // Contributions
            Route::resource('contributions', ContributionsController::class);
            Route::post('contributions/import', [ContributionsController::class, 'import'])->name('contributions.import');
            Route::post('/contributions/{contribution}/schedule-reminder', [ContributionsController::class, 'scheduleReminder'])->name('contributions.scheduleReminder');

            // Events
            Route::resource('events', EventsController::class);

            // Activities
            Route::get('/activities', [ActivityController::class, 'index'])->name('activities');

            // Reports
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/', [ReportsController::class, 'index'])->name('index');
                Route::get('/generate/{type}/{format?}', [ReportsController::class, 'generate'])
                    ->name('generate')
                    ->where([
                        'type' => 'contributions|members|events|resources',
                        'format' => 'pdf|excel|csv'
                    ]);
                Route::post('/download', [ReportsController::class, 'download'])->name('download');
                Route::get('/export/{id}/{format}', [ReportsController::class, 'export'])->name('export');
            });

            // Notifications (Fixed routes)
            Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
            Route::get('/notifications/create', [AdminNotificationController::class, 'create'])->name('notifications.create');
            Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');
            Route::get('/notifications/{id}', [AdminNotificationController::class, 'show'])->name('notifications.show');
        });

    // Member routes
    Route::prefix('member')
        ->name('member.')
        ->middleware(['member'])
        ->group(function () {

            Route::get('/dashboard', [MembersDashboardController::class, 'index'])->name('dashboard');

            // Contributions
            Route::prefix('contributions')->name('contributions.')->group(function () {
                Route::get('/', [MemberContributionController::class, 'index'])->name('index');
                Route::get('/create', [MemberContributionController::class, 'create'])->name('create');
                Route::post('/', [MemberContributionController::class, 'store'])->name('store');
                Route::get('/{contribution}', [MemberContributionController::class, 'show'])->name('show');
                Route::get('/{contribution}/receipt', [MemberContributionController::class, 'downloadReceipt'])->name('receipt');
                Route::get('/{contribution}/history', [MemberContributionController::class, 'history'])->name('history');
                Route::get('/{contribution}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
            });

            // Resources
            Route::prefix('resources')->name('resources.')->group(function () {
                Route::get('/', [ResourceController::class, 'index'])->name('index');
                Route::get('/resource', [ResourceController::class, 'show'])->name('show');
                Route::get('/resource/download', [ResourceController::class, 'download'])->name('download');
            });

            // Payments
            Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
            Route::get('/payments/success/{payment}', [PaymentController::class, 'success'])->name('payments.success');

            // Events
            Route::prefix('events')->name('events.')->group(function () {
                Route::get('/', [MemberController::class, 'indexEvents'])->name('index');
                Route::get('/{event}', [MemberController::class, 'showEvent'])->name('show');
                Route::post('/{event}/attend', [MemberController::class, 'attendEvent'])->name('attend');
                Route::get('/{event}/confirmation', [MemberController::class, 'eventConfirmation'])->name('confirmation');
            });

            // Activities
            Route::prefix('activities')->name('activities.')->group(function () {
                Route::get('/', [MemberController::class, 'indexActivities'])->name('index');
                Route::get('/{activity}', [MemberController::class, 'showActivity'])->name('show');
            });
        });

    // Notifications (general for all users)
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });

    // Payment gateways
    Route::prefix('mpesa')->name('mpesa.')->group(function () {
        Route::post('/payment', [PaymentController::class, 'initiatePayment'])->name('payment');
        Route::post('/callback', [MpesaController::class, 'callback'])->name('callback');
    });

    Route::prefix('clickpesa')->name('clickpesa.')->group(function () {
        Route::post('/payment', [ClickPesaController::class, 'initiate'])->name('payment');
        Route::post('/callback', [ClickPesaController::class, 'callback'])->name('callback');
    });

    // Test Routes (for development)
    Route::get('/test-mpesa-token', function () {
        $mpesaService = app(App\Services\MpesaService::class);
        return response()->json($mpesaService->testWithDirectToken());
    });

    Route::get('/send-test-email', function () {
        Mail::raw('This is a test email sent via Mailtrap.', function ($message) {
            $message->to('ludovickpancras@gmail.com')->subject('Test Email');
        });
        return 'Test email sent!';
    });

    Route::get('/test-notification', function () {
        $user = User::first();
        $user->notify(new TestNotification());
        return 'Notification sent!';
    });

    Route::get('/test-assets', function () {
        return view('asset-test', [
            'paths' => [
                asset('admindashboard.png'),
                asset('admincontributions.png'),
                asset('adminresources.png')
            ]
        ]);
    });
    // Route::post('/pay', [PaymentController::class, 'payViaMobile']);



// For web testing (temporary route)
Route::get('/test-payment', [PaymentController::class, 'initiatePayment']);

// For actual API implementation (use POST)
Route::post('/make-payment', [PaymentController::class, 'initiatePayment'])->name('make-payment');


    // Fallback route for 404s
    Route::fallback(function () {
        return view('errors.404');
    });
});
