<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Models\Jumuiya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'jumuiya'])->paginate(10);
        return view('super_admin.members.index', compact('members'));
    }

    public function create()
    {
        $jumuiyas = Jumuiya::all();
        return view('super_admin.members.create', compact('jumuiyas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'password' => 'required|string|confirmed|min:8',
            'status' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'member',
        ]);

        Member::create([
            'user_id' => $user->id,
            'jumuiya_id' => $validated['jumuiya_id'],
            'dob' => $validated['dob'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        return redirect()->route('super_admin.members.index')->with('success', 'Member created successfully');
    }

    public function show(Member $member)
    {
        $member->load(['user', 'jumuiya']);
        return view('super_admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $jumuiyas = Jumuiya::all();
        $member->load(['user', 'jumuiya']);
        return view('super_admin.members.edit', compact('member', 'jumuiyas'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($member->user_id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($member->user_id)],
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $member->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        $member->update([
            'jumuiya_id' => $validated['jumuiya_id'],
            'dob' => $validated['dob'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        return redirect()->route('super_admin.members.index')->with('success', 'Member updated successfully');
    }

    public function destroy(Member $member)
    {
        $member->user->delete();
        $member->delete();
        return redirect()->route('super_admin.members.index')->with('success', 'Member deleted successfully');
    }
}
