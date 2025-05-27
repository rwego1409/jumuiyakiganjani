<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\Jumuiya;
use Illuminate\Http\Request;
use App\Mail\UserCredentials;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notifications\ChairpersonMembershipNotification;
use App\Notifications\ChairpersonActionNotification;

class UsersController extends Controller
{
    public function index()
    {
        $jumuiya = auth()->user()->chairperson_of;
        $members = Member::with(['user'])
            ->where('jumuiya_id', $jumuiya->id)
            ->latest()
            ->paginate(10);

        return view('chairperson.users.index', compact('members'));
    }

    public function create()
    {
        $jumuiya = auth()->user()->chairperson_of;
        return view('chairperson.users.create', compact('jumuiya'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'joined_date' => 'nullable|date',
        ]);

        // Generate a random password
        $password = Str::random(10);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'role' => 'member',
        ]);

        // Get the chairperson's jumuiya
        $jumuiya = auth()->user()->chairperson_of;

        // Create member record
        $member = Member::create([
            'user_id' => $user->id,
            'jumuiya_id' => $jumuiya->id,
            'phone' => $request->phone,
            'status' => $request->status,
            'joined_date' => $request->joined_date ?? now(),
        ]);

        // Send email with credentials if requested
        if ($request->send_credentials) {
            Mail::to($user->email)->send(new UserCredentials($user, $password));
        }

        return redirect()->route('chairperson.users.index')
            ->with('success', 'Member added successfully.');
    }

    public function edit(Member $member)
    {
        $this->authorize('update', $member);
        return view('chairperson.users.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $this->authorize('update', $member);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->user_id,
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:255',
        ]);

        // Update user details
        $member->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update member details
        $member->update([
            'phone' => $request->phone,
            'status' => $request->status,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'address' => $request->address,
        ]);

        // Send notification to the member
        $member->user->notify(new ChairpersonMembershipNotification(
            $member,
            'updated'
        ));

        // If status changed to inactive, send additional notification
        if ($request->status === 'inactive' && $member->getOriginal('status') === 'active') {
            $member->user->notify(new ChairpersonActionNotification(
                'Membership Status Changed',
                'Your membership status has been changed to inactive.',
                'View Details',
                route('member.profile'),
                auth()->user()
            ));
        }

        return redirect()->route('chairperson.users.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $this->authorize('delete', $member);

        // Send notification before deleting
        $member->user->notify(new ChairpersonActionNotification(
            'Membership Terminated',
            'Your membership has been terminated.',
            'Contact Support',
            route('contact'),
            auth()->user()
        ));

        $member->user->delete(); // This will cascade delete the member record
        
        return redirect()->route('chairperson.users.index')
            ->with('success', 'Member removed successfully.');
    }

    public function approve(Member $member)
    {
        $this->authorize('update', $member);

        $member->update(['status' => 'active']);
        
        $member->user->notify(new ChairpersonMembershipNotification(
            $member,
            'approved'
        ));

        return back()->with('success', 'Member approved successfully.');
    }

    public function reject(Request $request, Member $member)
    {
        $this->authorize('update', $member);

        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $member->update(['status' => 'inactive']);
        
        $member->user->notify(new ChairpersonMembershipNotification(
            $member,
            'rejected',
            $request->reason
        ));

        return back()->with('success', 'Member rejected successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'members' => 'required|array',
            'members.*' => 'exists:members,id'
        ]);

        $members = Member::with('user')->whereIn('id', $request->members)->get();
        
        foreach ($members as $member) {
            $this->authorize('update', $member);

            switch ($request->action) {
                case 'approve':
                    $member->update(['status' => 'active']);
                    $member->user->notify(new ChairpersonMembershipNotification($member, 'approved'));
                    break;

                case 'reject':
                    $member->update(['status' => 'inactive']);
                    $member->user->notify(new ChairpersonMembershipNotification(
                        $member,
                        'rejected',
                        'Bulk action by chairperson'
                    ));
                    break;

                case 'delete':
                    $member->user->notify(new ChairpersonActionNotification(
                        'Membership Terminated',
                        'Your membership has been terminated as part of a bulk action.',
                        'Contact Support',
                        route('contact'),
                        auth()->user()
                    ));
                    $member->user->delete();
                    break;
            }
        }

        return back()->with('success', 'Bulk action completed successfully.');
    }
}
