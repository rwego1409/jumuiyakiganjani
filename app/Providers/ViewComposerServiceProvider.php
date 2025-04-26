<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.navigation.member', function ($view) {
            $notificationsData = [
                'member' => [
                    'count' => Auth::check() ? Auth::user()->unreadNotifications()->count() : 0,
                    'items' => Auth::check() ? Auth::user()->unreadNotifications()->take(5)->get() : []
                ]
            ];
            
            $view->with('notificationsData', $notificationsData);
        });
    }
}
