<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.navigation.*', function ($view) {
            $user = auth()->user();
            if ($user) {
                $view->with('unreadCount', $user->unreadNotifications()->count());
            }
        });
    }
}
