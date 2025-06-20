<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chairperson\DashboardController;
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
    ClickPesaController,
    PalmPesaController
};
use App\Http\Controllers\SuperAdmin\{
    SuperAdminController,
    JumuiyaController,
    ChairpersonsController,
    MembersController as SuperAdminMembersController,
    NotificationController as SuperAdminNotificationController
};
use App\Http\Controllers\ZenoPayController;
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

    // Super Admin routes
    Route::prefix('super-admin')
        ->name('super_admin.')
        ->middleware(['super_admin'])
        ->group(function () {
            // Dashboard
            Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'dashboard'])->name('dashboard');
            
            // Jumuiya Management
            Route::resource('jumuiyas', App\Http\Controllers\SuperAdmin\JumuiyaController::class);

            // Admin Management
            Route::resource('admins', App\Http\Controllers\Admin\AdminManagementController::class);
            Route::get('admins/{admin}/activities', [App\Http\Controllers\Admin\AdminManagementController::class, 'activities'])
                ->name('admins.activities');

            // Chairpersons Management
            Route::resource('chairpersons', App\Http\Controllers\SuperAdmin\ChairpersonsController::class);

            // Members Management
            Route::resource('members', App\Http\Controllers\SuperAdmin\MembersController::class);

            // Notifications
            Route::resource('notifications', NotificationController::class);

            // Notifications Management for Super Admin
            Route::prefix('notifications')->name('notifications.')->group(function () {
                Route::get('/', [App\Http\Controllers\SuperAdmin\SuperAdminNotificationController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\SuperAdmin\SuperAdminNotificationController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\SuperAdmin\SuperAdminNotificationController::class, 'store'])->name('store');
                Route::get('/{notification}', [App\Http\Controllers\SuperAdmin\SuperAdminNotificationController::class, 'show'])->name('show');
                Route::post('/mark-all-read', [App\Http\Controllers\SuperAdmin\SuperAdminNotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            });

            // System Settings
            Route::get('/settings', [App\Http\Controllers\Admin\SuperAdminSettingsController::class, 'index'])->name('settings');
            Route::put('/settings', [App\Http\Controllers\Admin\SuperAdminSettingsController::class, 'update'])->name('settings.update');
        });

    // Chairperson routes
    Route::prefix('chairperson')
        ->name('chairperson.')
        ->middleware(['chairperson'])
        ->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\Chairperson\DashboardController::class, 'index'])->name('dashboard');
            
            // Contributions management
            Route::resource('contributions', App\Http\Controllers\Chairperson\ContributionsController::class);
            Route::post('/contributions/{contribution}/schedule-reminder', [App\Http\Controllers\Chairperson\ContributionsController::class, 'scheduleReminder'])->name('contributions.scheduleReminder');
            Route::post('/contributions/{contribution}/send-notification', [App\Http\Controllers\Chairperson\ContributionsController::class, 'sendNotification'])->name('contributions.sendNotification');
            
            // Members management
            Route::resource('members', App\Http\Controllers\Chairperson\MembersController::class);

            // Events management
            Route::resource('events', App\Http\Controllers\Chairperson\EventsController::class);

            // Resources management
            // Download resource file
            Route::get('resources/{resource}/download', [App\Http\Controllers\Chairperson\ResourcesController::class, 'download'])->name('resources.download');
            Route::resource('resources', App\Http\Controllers\Chairperson\ResourcesController::class);
            
            // Notifications
            // Notifications Management
            Route::prefix('notifications')->name('notifications.')->group(function () {
                Route::get('/', [App\Http\Controllers\Chairperson\NotificationController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Chairperson\NotificationController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Chairperson\NotificationController::class, 'store'])->name('store');
                Route::get('/{notification}', [App\Http\Controllers\Chairperson\NotificationController::class, 'show'])->name('show');
                Route::post('/mark-all-read', [App\Http\Controllers\Chairperson\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            });

            // Settings Management
            Route::get('settings', [App\Http\Controllers\Chairperson\SettingsController::class, 'index'])->name('settings.index');
            Route::put('settings', [App\Http\Controllers\Chairperson\SettingsController::class, 'update'])->name('settings.update');
            Route::get('notifications/create', [App\Http\Controllers\Chairperson\NotificationController::class, 'create'])->name('notifications.create');
            Route::post('notifications', [App\Http\Controllers\Chairperson\NotificationController::class, 'store'])->name('notifications.store');
            Route::get('notifications/{notification}', [App\Http\Controllers\Chairperson\NotificationController::class, 'show'])->name('notifications.show');
            Route::post('notifications/mark-all-read', [App\Http\Controllers\Chairperson\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

            // WhatsApp Reminders
            Route::get('reminders', [App\Http\Controllers\Chairperson\RemindersController::class, 'index'])->name('reminders.index');
            Route::post('reminders', [App\Http\Controllers\Chairperson\RemindersController::class, 'store'])->name('reminders.store');

            // Reports Management
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/', [App\Http\Controllers\Chairperson\ReportsController::class, 'index'])->name('index');
                Route::get('/generate/{type}/{format?}', [App\Http\Controllers\Chairperson\ReportsController::class, 'generate'])->name('generate');
                Route::post('/download', [App\Http\Controllers\Chairperson\ReportsController::class, 'download'])->name('download');
                Route::get('/export/{id}/{format}', [App\Http\Controllers\Chairperson\ReportsController::class, 'export'])->name('export');
            });
        });

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
            Route::post('/contributions/{contribution}/send-notification', [ContributionsController::class, 'sendNotification'])->name('contributions.sendNotification');
            Route::get('/contributions/export/pdf', [ContributionsController::class, 'exportPdf'])->name('contributions.export.pdf');
            Route::get('/contributions/export/excel', [ContributionsController::class, 'exportExcel'])->name('contributions.export.excel');

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

            // Jumuiya Management
            Route::prefix('jumuiyas')->name('jumuiyas.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\JumuiyasController::class, 'index'])->name('index');
                Route::get('/{jumuiya}', [\App\Http\Controllers\Admin\JumuiyasController::class, 'show'])->name('show');
                Route::get('/{jumuiya}/edit', [\App\Http\Controllers\Admin\JumuiyasController::class, 'edit'])->name('edit');
                Route::put('/{jumuiya}', [\App\Http\Controllers\Admin\JumuiyasController::class, 'update'])->name('update');
                Route::delete('/{jumuiya}', [\App\Http\Controllers\Admin\JumuiyasController::class, 'destroy'])->name('destroy');
            });

            Route::resource('chairpersons', \App\Http\Controllers\Admin\ChairpersonsController::class);
            
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
            });

            // Payments
            Route::prefix('payments')->name('payments.')->group(function () {
                Route::get('/create/{contribution}', [PaymentController::class, 'create'])->name('create');
                Route::post('/', [PaymentController::class, 'store'])->name('store');
                Route::get('/', [PaymentController::class, 'index'])->name('index');
                Route::get('/success/{payment}', [PaymentController::class, 'success'])->name('success');
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

            // Notifications for members
            Route::prefix('notifications')->name('notifications.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Members\NotificationController::class, 'index'])->name('index');
                Route::get('/{notification}', [\App\Http\Controllers\Members\NotificationController::class, 'show'])->name('show');
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

Route::get('/payment', function () {
    return view('payment.form');
})->name('payment.form');

Route::post('/process-payment', [PaymentController::class, 'initiatePayment'])
     ->name('payment.process');

// Add this with your other routes
Route::get('/payment/success', function () {
    return view('member.payment-success');
})->name('payment.success');

Route::post('/payment/callback', [PaymentController::class, 'paymentCallback']);
Route::get('/payment/callback', function () {
    return view('payment.callback');
})->name('payment.callback');

// routes/web.php
// routes/web.php
Route::get('/test-stk-push', function() {
    $phone = request('phone', '255625369871');
    $amount = request('amount', 1000);
    
    $service = app()->make(App\Services\PalmPesaService::class);
    $response = $service->processPayment(
        $phone,
        $amount,
        'TEST-' . time()
    );
    
    return response()->json([
        'diagnostic' => [
            'input_phone' => $phone,
            'environment' => app()->environment(),
            'timestamp' => now()->toDateTimeString()
        ],
        'api_response' => $response
    ]);
});
Route::prefix('payments')->group(function() {
    Route::post('/stk-push', [PaymentController::class, 'stkPush']); // Existing
    Route::post('/mobile', [PaymentController::class, 'mobilePayment']); // New
});

Route::get('/test-mobile-payment', function() {
    $service = app()->make(App\Services\PalmPesaService::class);
    
    $testData = [
        'user_id' => 2,
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '255625369871', // Test with your number
        'amount' => 1000,
        'transaction_id' => 'TXN-' . time(),
        'address' => 'Dar es Salaam',
        'postcode' => '12345',
        'buyer_uuid' => 123456
    ];

    $result = $service->processMobilePayment($testData);
    
    return response()->json([
        'test_data' => $testData,
        'result' => $result,
        'logs' => 'Check storage/logs/palmpesa.log for details'
    ]);
});
// routes/web.php
Route::prefix('palmpesa')->group(function() {
    Route::get('/debug', [\App\Http\Controllers\PalmPesaDebugController::class, 'testStkPush']);
    Route::post('/debug', [\App\Http\Controllers\PalmPesaDebugController::class, 'testStkPush']);
});
// Check payment status
Route::get('/payment/status/{reference}', function($reference) {
    // Implement status check with PalmPesa API
    return response()->json([
        'status' => 'pending', // or 'completed'/'failed'
        'reference' => $reference
    ]);
});

// Superuser WhatsApp Reminders Management
Route::prefix('superuser')
    ->name('superuser.')
    ->middleware(['auth', 'role:super_user'])
    ->group(function () {
        Route::resource('whatsapp_reminders', App\Http\Controllers\Superuser\WhatsAppRemindersController::class);
    });

Route::get('/test-notification', function() {
    $admin = \App\Models\User::where('role', 'admin')->first();
    
    if (!$admin) {
        return 'No admin user found!';
    }
    
    $notification = \App\Models\AdminNotification::create([
        'title' => 'Test Notification for Chairperson',
        'message' => 'This is a test notification to verify chairperson notifications are working.',
        'type' => 'general',
        'recipients' => ['all'],
        'created_by' => $admin->id
    ]);

    \App\Jobs\DispatchNotifications::dispatch($notification);
    
    return 'Test notification sent!';
});

// ZenoPay routes
Route::prefix('zenopay')->name('zenopay.')->group(function () {
    Route::post('/initiate', [ZenoPayController::class, 'initiate'])->name('initiate');
    Route::get('/status', [ZenoPayController::class, 'status'])->name('status');
});

// Fallback route for 404s
    Route::fallback(function () {
        return view('errors.404');
    });
});
