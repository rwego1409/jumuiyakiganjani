<?php

use App\Http\Controllers\Admin\ContributionsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\ResourcesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Members\DashboardController as MembersDashboardController;
use App\Http\Controllers\Members\MemberController;
use App\Http\Controllers\Members\ResourceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['admin'])
        ->group(function () {
            // Dashboard
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');
                
            // Settings
            Route::get('/settings', [SettingsController::class, 'index'])
                ->name('settings');
            
            // Activities
            Route::get('/activities', [ActivityController::class, 'index'])
                ->name('activities');
            
            // Members resource
            Route::resource('members', MembersController::class)
                ->names([
                    'index' => 'members.index',
                    'show' => 'members.show',
                    'edit' => 'members.edit',
                    'update' => 'members.update',
                    'destroy' => 'members.destroy',
                    'create' => 'members.create',
                    'store' => 'members.store',
                ]);
            
            // Contributions resource
            Route::resource('contributions', ContributionsController::class)
                ->names([
                    'index' => 'contributions.index',
                    'create' => 'contributions.create',
                    'store' => 'contributions.store',
                    'show' => 'contributions.show',
                    'edit' => 'contributions.edit',
                    'update' => 'contributions.update',
                    'destroy' => 'contributions.destroy'
                ]);
            
            // Events resource
            Route::resource('events', EventsController::class)
                ->names([
                    'index' => 'events.index',
                    'create' => 'events.create',
                    'store' => 'events.store',
                    'show' => 'events.show',
                    'edit' => 'events.edit',
                    'update' => 'events.update',
                    'destroy' => 'events.destroy'
                ]);
            
            // Resources resource
            Route::resource('resources', ResourcesController::class)
                ->names([
                    'index' => 'resources.index',
                    'create' => 'resources.create',
                    'store' => 'resources.store',
                    'show' => 'resources.show',
                    'edit' => 'resources.edit',
                    'update' => 'resources.update',
                    'destroy' => 'resources.destroy'
                ]);
            
            // Custom download route for resources
            Route::get('resources/{resource}/download', [ResourcesController::class, 'download'])
                ->name('resources.download');

            // Reports
            Route::resource('reports', ReportsController::class)
                ->only(['index', 'show', 'store'])
                ->names([
                    'index' => 'reports.index',
                    'show' => 'reports.show',
                    'store' => 'reports.generate',
                    'create' => 'reports.create',
                    'edit' => 'reports.edit',
                    'update' => 'reports.update',
                    'destroy' => 'reports.destroy'
                ]);

            Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
            Route::get('/reports/generate', [ReportsController::class, 'generate'])->name('reports.generate');
        });

    // Member routes
    Route::prefix('member')
        ->name('member.')
        ->middleware(['member'])
        ->group(function () {
            // Dashboard
            Route::get('/dashboard', [MembersDashboardController::class, 'index'])
                ->name('dashboard');

            // Notifications
            Route::get('/notifications', [MemberController::class, 'notifications'])
                ->name('notifications');
            
            // Contributions
            Route::prefix('contributions')->name('contributions.')->group(function () {
                Route::get('/', [MemberController::class, 'indexContributions'])
                    ->name('index');
                Route::get('/create', [MemberController::class, 'createContribution'])
                    ->name('create');
                Route::post('/', [MemberController::class, 'storeContribution'])
                    ->name('store');
                Route::get('/{contribution}', [MemberController::class, 'showContribution'])
                    ->name('show');
                Route::get('/{contribution}/receipt', [MemberController::class, 'downloadReceipt'])
                    ->name('receipt');
            });

            // Resources
            Route::prefix('resources')->name('resources.')->group(function () {
                Route::get('/', [MemberController::class, 'indexResources'])
                    ->name('index');
                Route::get('/{resource}', [MemberController::class, 'showResource'])
                    ->name('show');
                Route::get('/{resource}/download', [MemberController::class, 'downloadResource'])
                    ->name('download');
            });

            // Events
            Route::prefix('events')->name('events.')->group(function () {
                Route::get('/', [MemberController::class, 'indexEvents'])
                    ->name('index');
                Route::get('/{event}', [MemberController::class, 'showEvent'])
                    ->name('show');
                Route::post('/{event}/attend', [MemberController::class, 'attendEvent'])
                    ->name('attend');
                Route::get('/{event}/confirmation', [MemberController::class, 'eventConfirmation'])
                    ->name('confirmation');
            });

            // Activities
            Route::prefix('activities')->name('activities.')->group(function () {
                Route::get('/', [MemberController::class, 'indexActivities'])
                    ->name('index');
                Route::get('/{activity}', [MemberController::class, 'showActivity'])
                    ->name('show');
            });
        });
    
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    
    // Fallback route for undefined paths
    Route::fallback(function () {
        return view('errors.404');
    });
});