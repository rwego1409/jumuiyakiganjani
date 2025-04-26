<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Jumuiya;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $member = $user->member; // this can be null for admins
        $jumuiyas = Jumuiya::all();
        
        return view('profile.edit', [
            'user' => $user,
            'member' => $member,
            'jumuiyas' => $jumuiyas
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $member = $user->member; // May be null for admins

    // Update basic user details (name, email)
    $user->fill($request->only('name', 'email', 'phone'));

    // Check if the email has changed
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;  // Reset email verification if email is changed
    }

    $user->save();

    // If the user is a member, handle member-specific fields
    if ($member) {
        // Update member-specific fields (address, birth_date) in the members table
        $member->update([
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'jumuiya_id' => $request->jumuiya_id
        ]);

        // Handle profile picture upload for members
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($member->profile_picture) {
                Storage::disk('public')->delete($member->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $member->profile_picture = $path;
        }

        $member->save();
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $member = $user->member;

        // If the user is a member, delete the profile picture if it exists
        if ($member && $member->profile_picture) {
            Storage::disk('public')->delete($member->profile_picture);
        }

        // Log out the user and delete their account
        Auth::logout();
        $user->delete();

        // Invalidate the session and regenerate the token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update just the profile picture.
     */
    public function updatePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'max:2048']
        ]);

        $user = $request->user();
        $member = $user->member;

        // If the user is a member and the request has a file
        if ($member && $request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($member->profile_picture) {
                Storage::disk('public')->delete($member->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $member->profile_picture = $path;
            $member->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-picture-updated');
    }
}
