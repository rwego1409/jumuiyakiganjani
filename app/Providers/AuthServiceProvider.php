<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Notifications\DatabaseNotification;
use App\Policies\NotificationPolicy;
use App\Models\User;
use App\Models\AdminNotification;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        DatabaseNotification::class => NotificationPolicy::class,
        // Add other model-policy mappings here as needed
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define admin gate
        Gate::define('admin', function (User $user) {
            return $user->is_admin === true; // or $user->role === 'admin' depending on your user model
        });

        // Define member gate
        Gate::define('member', function (User $user) {
            return $user->is_member === true || $user->role === 'member';
        });

        // Notification-related gates
        Gate::define('view-notification', function (User $user, DatabaseNotification $notification) {
            return $user->id === $notification->notifiable_id;
        });

        Gate::define('create-admin-notification', function (User $user) {
            return $user->is_admin;
        });

        // Admin notification policy (if you create a specific policy for it)
        Gate::define('view-admin-notification', function (User $user, AdminNotification $notification) {
            return $user->is_admin || $notification->created_by === $user->id;
        });

        // Additional authorization checks can be added here
    }
}