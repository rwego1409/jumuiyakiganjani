<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jumuiya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use function Spatie\Activitylog\activity;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->paginate(10);
        return view('admin.super.admins.index', compact('admins'));
    }

    public function create()
    {
        $jumuiyas = Jumuiya::all();
        return view('admin.super.admins.create', compact('jumuiyas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'assigned_jumuiyas' => ['array'],
            'assigned_jumuiyas.*' => ['exists:jumuiyas,id']
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'admin'
        ]);

        if (isset($validated['assigned_jumuiyas'])) {
            $admin->managedJumuiyas()->attach($validated['assigned_jumuiyas']);
        }

        // Log the activity
        activity()
            ->performedOn($admin)
            ->causedBy(auth()->user())
            ->withProperties([
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
                'managed_jumuiyas' => $validated['assigned_jumuiyas'] ?? []
            ])
            ->log('created_admin');

        return redirect()->route('super_admin.admins.index')
            ->with('success', 'Administrator created successfully');
    }    public function edit(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        $jumuiyas = Jumuiya::all();
        $assignedJumuiyas = Jumuiya::where('chairperson_id', $admin->id)->pluck('id')->toArray();
        
        return view('admin.super.admins.edit', compact('admin', 'jumuiyas', 'assignedJumuiyas'));
    }

    public function update(Request $request, User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'phone' => ['required', 'string', 'max:15', 'unique:users,phone,' . $admin->id],
            'password' => ['nullable', Rules\Password::defaults()],
            'assigned_jumuiyas' => ['array'],
            'assigned_jumuiyas.*' => ['exists:jumuiyas,id'],
            'status' => ['required', 'in:active,inactive']
        ]);

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => $validated['status']
        ]);

        if ($validated['password'] ?? false) {
            $admin->update(['password' => Hash::make($validated['password'])]);
        }

        if (isset($validated['assigned_jumuiyas'])) {
            $admin->managedJumuiyas()->sync($validated['assigned_jumuiyas']);
        }

        // Log the activity
        activity()
            ->performedOn($admin)
            ->causedBy(auth()->user())
            ->withProperties([
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
                'status' => $validated['status'],
                'password_changed' => isset($validated['password']),
                'managed_jumuiyas' => $validated['assigned_jumuiyas'] ?? []
            ])
            ->log('updated_admin');

        return redirect()->route('super_admin.admins.index')
            ->with('success', 'Administrator updated successfully');
    }

    public function destroy(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        // Log the activity before deletion
        activity()
            ->performedOn($admin)
            ->causedBy(auth()->user())
            ->withProperties([
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
                'managed_jumuiyas' => $admin->managedJumuiyas->pluck('name')->toArray()
            ])
            ->log('deleted_admin');

        $admin->managedJumuiyas()->detach();
        $admin->delete();

        return redirect()->route('super_admin.admins.index')
            ->with('success', 'Administrator deleted successfully');
    }

    public function activities(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);
        
        $activities = activity()
            ->performedOn($admin)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.super.admins.activities', compact('admin', 'activities'));
    }

    /**
     * Display the specified admin.
     */
    public function show($id)
    {
        $admin = User::findOrFail($id);
        abort_if($admin->role !== 'admin', 404);

        // Get jumuiyas where this admin is a chairperson
        $jumuiyas = Jumuiya::with('members')
            ->where('chairperson_id', $admin->id)
            ->get();
            
        $totalMembers = $jumuiyas->sum(function ($jumuiya) {
            return $jumuiya->members->count();
        });

        return view('admin.super.admins.show', compact('admin', 'jumuiyas', 'totalMembers'));
    }
}
