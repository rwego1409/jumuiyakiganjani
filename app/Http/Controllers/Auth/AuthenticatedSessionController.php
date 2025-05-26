<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->isSuper_Admin()) {
            return route('super_admin.dashboard');
        }
        
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        }

        if ($user->isChairperson()) {
            return route('chairperson.dashboard');
        }

        if ($user->isMember()) {
            return route('member.dashboard');
        }

        // Default redirect to member dashboard if no specific role matched
        return route('member.dashboard');
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended($this->redirectTo());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
