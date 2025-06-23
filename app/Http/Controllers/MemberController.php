<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use App\Models\User;
use App\Models\Jumuiya;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'jumuiya'])->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $jumuiyas = Jumuiya::all();
        return view('admin.members.create', compact('jumuiyas'));
    }

    public function store(StoreMemberRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role' => 'member'
        ]);

        Member::create([
            'user_id' => $user->id,
            'jumuiya_id' => $request->jumuiya_id,
            'phone' => $request->phone,
            'status' => $request->status,
            'joined_date' => $request->joined_date
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member created successfully');
    }

    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $jumuiyas = Jumuiya::all();
        return view('admin.members.edit', compact('member', 'jumuiyas'));
    }

    public function update(StoreMemberRequest $request, Member $member)
    {
        $member->user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $member->update($request->only([
            'jumuiya_id', 'phone', 'status', 'joined_date'
        ]));

        return redirect()->route('admin.members.index')
            ->with('success', 'Member updated successfully');
    }

    public function destroy(Member $member)
    {
        $member->user->delete();
        $member->delete();
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully');
    }

    /**
     * Update the role of a member's user account.
     */
    public function updateRole(Request $request, Member $member)
    {
        $request->validate([
            'role' => 'required|in:member,chairperson,admin',
        ]);

        $user = $member->user;
        $user->role = $request->input('role');
        $user->save();

        return back()->with('success', __('Role updated successfully.'));
    }
}