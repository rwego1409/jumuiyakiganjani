<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // List all users (Super Admin can see and manage all)
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(15);
        return view('super_admin.admins.index', compact('users'));
    }

    // Show a single user
    public function show(User $user)
    {
        return view('super_admin.admins.show', compact('user'));
    }

    // Show create user form
    public function create()
    {
        return view('super_admin.admins.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:15', 'unique:users'],
            'role' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive,pending']
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status']
        ]);
        return redirect()->route('super_admin.users.index')->with('success', 'User created successfully');
    }

    // Show edit user form
    public function edit(User $user)
    {
        // Get all Jumuiyas
        $jumuiyas = \App\Models\Jumuiya::all();
        // Get assigned jumuiya IDs for this user (as chairperson or via pivot if you have a many-to-many)
        $assignedJumuiyas = $user->jumuiyas()->pluck('id')->toArray();

        // Determine the assigned jumuiya name (show only one, or join if multiple)
        $assignedJumuiyaName = null;
        if (count($assignedJumuiyas) === 1) {
            $assignedJumuiyaName = \App\Models\Jumuiya::find($assignedJumuiyas[0])?->name;
        } elseif (count($assignedJumuiyas) > 1) {
            $assignedJumuiyaName = \App\Models\Jumuiya::whereIn('id', $assignedJumuiyas)->pluck('name')->implode(', ');
        }

        return view('super_admin.admins.edit', compact('user', 'jumuiyas', 'assignedJumuiyas', 'assignedJumuiyaName'));
    }

    // Update a user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:15', 'unique:users,phone,' . $user->id],
            'role' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive,pending'],
            'password' => ['nullable', 'string', 'min:8']
        ]);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status']
        ]);
        if (!empty($validated['password'])) {
            $user->update(['password' => bcrypt($validated['password'])]);
        }
        return redirect()->route('super_admin.users.index')->with('success', 'User updated successfully');
    }

    // Delete a user
    public function destroy(User $user)
    {
        // Prevent super admin from deleting themselves (optional, for safety)
        if (auth()->id() === $user->id) {
            return redirect()->route('super_admin.users.index')->with('error', 'You cannot delete your own super admin account.');
        }
        $user->delete();
        return redirect()->route('super_admin.users.index')->with('success', 'User deleted successfully');
    }
}
