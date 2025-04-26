<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Member;
use App\Models\Jumuiya;
use App\Models\Notification;
use App\Models\Contribution;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Resource;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member'
        ]);

        // Create associated member record
        $member = Member::create([
            'user_id' => $user->id,
            'joined_date' => now(),
            'status' => 'active'
        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect()->route('verification.notice');

    }

    public function create()
    {
        $jumuiyas = Jumuiya::all(); // Or any query to get your jumuiyas
        return view('auth.register', compact('jumuiyas'));
    }
}
