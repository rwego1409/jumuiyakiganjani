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
    ProfileSetupController,
    NotificationController,
    ClickPesaController
};
use App\Http\Controllers\SuperAdmin\{
    SuperAdminController,
    JumuiyaController,
    ChairpersonsController,
    MembersController as SuperAdminMembersController,
    NotificationController as SuperAdminNotificationController
};
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Controllers\Members\PaymentController as MemberPaymentController;
use App\Http\Controllers\PaymentController;

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

            // User Management
            Route::resource('users', App\Http\Controllers\SuperAdmin\UserManagementController::class);

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

            // Activities (Super Admin)
            Route::get('activities', [App\Http\Controllers\SuperAdmin\ActivityController::class, 'index'])->name('activities.index');
            Route::get('activities/{activity}', [App\Http\Controllers\SuperAdmin\ActivityController::class, 'show'])->name('activities.show');
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

            // Events management - FIXED: Removed conflicting routes
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

            // Activities management
            Route::get('activities', [\App\Http\Controllers\Chairperson\ActivityController::class, 'index'])->name('activities.index');
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
            // Export (generic, for filtered export)
            Route::get('/contributions/export', [ContributionsController::class, 'export'])->name('contributions.export');

            // Events - FIXED: Removed conflicting routes
            Route::resource('events', EventsController::class);

            // Activities
            Route::get('/activities', [ActivityController::class, 'index'])->name('activities');
            Route::get('activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');

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
                Route::post('/initiate-clickpesa', [\App\Http\Controllers\Members\ContributionController::class, 'initiateClickPesa'])
                    ->name('initiateClickPesa');
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

    // Test STK Push route
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

    Route::match(['get', 'post'], '/test-mobile-payment', function(Request $request) {
        $tailwind = '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
        $container = 'max-w-md mx-auto mt-12 p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800';
        $title = '<h2 class="text-2xl font-bold mb-4 text-center bg-gradient-to-r from-pink-500 to-indigo-500 bg-clip-text text-transparent">Mock STK Push Payment</h2>';
        if ($request->isMethod('get')) {
            // Step 1: Payment data entry
            return response($tailwind.'<div class="'.$container.'">'.$title.'<form method="POST" class="space-y-4">'
                . csrf_field()
                . '<div><label class="block text-sm font-medium text-gray-700">Phone</label><input name="phone" value="255700000001" required class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500"></div>'
                . '<div><label class="block text-sm font-medium text-gray-700">Amount</label><input name="amount" value="1000" required class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500"></div>'
                . '<div><label class="block text-sm font-medium text-gray-700">Name</label><input name="name" value="Test User" class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500"></div>'
                . '<div><label class="block text-sm font-medium text-gray-700">Email</label><input name="email" value="test@example.com" class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500"></div>'
                . '<button type="submit" class="w-full py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-2xl shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-400">Start Payment</button>'
                . '</form></div>', 200);
        }
        $data = $request->only(['phone', 'amount', 'name', 'email']);
        if (!$request->has('secret_key')) {
            // Step 2: Mock STK Push menu
            return response($tailwind.'<div class="'.$container.'">'.$title.'<div class="mb-4 text-center text-gray-700">A mock STK Push has been sent to <span class="font-bold">'.e($data['phone']).'</span> for <span class="font-bold">'.e($data['amount']).' TZS</span>.<br>Enter your secret key to complete the payment.</div>'
                . '<form method="POST" class="space-y-4">'
                . csrf_field()
                . '<input type="hidden" name="phone" value="' . e($data['phone']) . '">' 
                . '<input type="hidden" name="amount" value="' . e($data['amount']) . '">' 
                . '<input type="hidden" name="name" value="' . e($data['name']) . '">' 
                . '<input type="hidden" name="email" value="' . e($data['email']) . '">' 
                . '<div><label class="block text-sm font-medium text-gray-700">Secret Key</label><input name="secret_key" type="password" required class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500"></div>'
                . '<button type="submit" class="w-full py-3 bg-gradient-to-r from-pink-500 via-violet-600 to-indigo-600 hover:from-pink-600 hover:via-violet-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-pink-400">Submit Secret Key</button>'
                . '</form></div>', 200);
        }
        // Step 3: Process payment as successful mock
        $payment = Payment::create([
            'transaction_id' => 'MOCK-' . uniqid(),
            'amount' => $data['amount'],
            'currency' => 'TZS',
            'phone_number' => $data['phone'],
            'buyer_email' => $data['email'],
            'buyer_name' => $data['name'],
            'status' => 'completed',
            'payment_method' => 'mock_stk',
            'user_id' => auth()->id(),
            'clickpesa_reference' => 'MOCK-REF-' . rand(100000, 999999),
            'gateway_response' => ['mock' => true, 'secret_key' => $request->input('secret_key')],
            'completed_at' => now(),
        ]);
        return response($tailwind.'<div class="'.$container.'">'.$title.'<div class="text-green-600 font-bold text-center mb-4">Payment processed and recorded as successful!</div>'
            . '<div class="bg-slate-100 rounded-xl p-4 text-sm text-gray-700"><b>Payment ID:</b> '.$payment->id.'<br><b>Phone:</b> '.e($data['phone']).'<br><b>Amount:</b> '.e($data['amount']).' TZS<br><b>Status:</b> completed</div>'
            . '<div class="mt-6 text-center"><a href="/test-mobile-payment" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-2xl font-bold shadow hover:from-blue-600 hover:to-indigo-600 transition">Make Another Payment</a></div></div>', 200);
    });

}); // This closes the main middleware group

// Superuser WhatsApp Reminders Management
Route::prefix('superuser')
    ->name('superuser.')
    ->middleware(['auth', 'role:super_user'])
    ->group(function () {
        Route::resource('whatsapp_reminders', App\Http\Controllers\Superuser\WhatsAppRemindersController::class);
    });

// ClickPesa manual integration routes
Route::post('/clickpesa/ussd', [App\Http\Controllers\ClickPesaController::class, 'ussdCheckout']);
Route::get('/clickpesa/status/{transactionId}', [App\Http\Controllers\ClickPesaController::class, 'queryStatus']);
Route::post('/clickpesa/webhook', [App\Http\Controllers\ClickPesaController::class, 'webhook'])->name('clickpesa.webhook');

// ClickPesa payment endpoint for member payment flow
Route::post('/clickpesa/payment', [App\Http\Controllers\ClickPesaController::class, 'ussdCheckout']);

// ClickPesa USSD-PUSH web endpoint for form POST
Route::match(['get', 'post'], '/clickpesa/ussd-push', [ClickPesaController::class, 'initiateUssdPush'])->name('clickpesa.ussd-push');

// ClickPesa payment status check (by orderReference)
Route::get('/clickpesa/payment-status/{orderReference}', [App\Http\Controllers\ClickPesaController::class, 'paymentStatusByOrderReference'])->name('clickpesa.payment-status');

// Public subscription routes
Route::get('/subscribe', [\App\Http\Controllers\SubscriptionController::class, 'create'])->name('subscription.create');
Route::post('/subscribe', [\App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscription.store');

// Fallback route for 404s
Route::fallback(function () {
    return view('errors.404');
});

// Admin-only routes
Route::middleware(['web', 'auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/activities', [App\Http\Controllers\Admin\ActivitiesController::class, 'index'])->name('admin.activities.index');
});

// Simple test POST route to verify Laravel is working
Route::post('/test-post', function (\Illuminate\Http\Request $request) {
    \Log::info('Test POST route hit', ['data' => $request->all()]);
    return response()->json(['success' => true, 'data' => $request->all()]);
});

// Route to verify a pending jumuiya by assigning a chairperson
Route::post('super-admin/jumuiyas/{jumuiya}/verify', [\App\Http\Controllers\SuperAdmin\JumuiyaController::class, 'verify'])->name('super_admin.jumuiyas.verify');

// Super Admin Members - Update Role
Route::patch('super_admin/members/{member}/update-role', [App\Http\Controllers\SuperAdmin\MembersController::class, 'updateRole'])->name('super_admin.members.updateRole');

// ClickPesa callback route with signature verification middleware
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Contribution;

Route::post('/clickpesa/callback', function (\Illuminate\Http\Request $request) {
    $signature = hash_hmac('sha256', $request->reference, env('CLICKPESA_API_KEY'));
    if (!hash_equals($signature, $request->header('X-ClickPesa-Signature'))) {
        Log::error('Invalid ClickPesa signature', ['ip' => $request->ip(), 'data' => $request->all()]);
        abort(403);
    }

    DB::transaction(function () use ($request) {
        $payment = App\Models\Payment::where('reference', $request->reference)->firstOrFail();
        $payment->update([
            'status' => $request->status === 'success' ? 'paid' : 'failed',
            'payment_data' => $request->all()
        ]);
        if ($payment->status === 'paid') {
            $contribution = Contribution::find($payment->contribution_id);
            if ($contribution) {
                $contribution->update(['status' => 'paid']);
            }
        }
    });

    return response()->json(['status' => 'received']);
});

// Diagnostic route for debugging asset and app URLs
Route::get('/diag', function() {
    return response()->json([
        'asset_url' => asset('css/app.css'),
        'config_app_url' => config('app.url'),
        'request_host' => request()->getHost()
    ]);
});