<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the member's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('members.profile.edit', compact('user'));
    }

    /**
     * Update the member's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            // Add other fields as needed
        ]);

        $user->update($validated);

        return redirect()->route('member.profile.edit')
                         ->with('success', 'Profile updated successfully');
    }

    /**
     * Display the member's profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('members.profile.view', compact('user'));
    }
}