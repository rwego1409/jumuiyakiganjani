<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                if ($user->isSuper_Admin()) {
                    return redirect()->route('super_admin.dashboard');
                } elseif ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->isChairperson()) {
                    return redirect()->route('chairperson.dashboard');
                }
                return redirect()->route('member.dashboard');
            }
        }

        return $next($request);
    }
}
