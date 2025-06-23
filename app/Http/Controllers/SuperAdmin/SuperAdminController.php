<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Jumuiya;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuper_Admin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalJumuiyas = Jumuiya::count();
        $totalChairpersons = User::where('role', 'chairperson')->count();
        $totalMembers = Member::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $recentJumuiyas = Jumuiya::with('chairperson')->latest()->take(5)->get();

        // Fetch recent activities for super admin dashboard
        $recentActivities = \App\Models\Activity::with('user')->latest()->take(5)->get();

        return view('super_admin.dashboard', compact(
            'totalJumuiyas',
            'totalChairpersons',
            'totalMembers',
            'totalAdmins',
            'recentJumuiyas',
            'recentActivities'
        ));
    }

    public function jumuiyasList()
    {
        $jumuiyas = Jumuiya::with('chairperson')->latest()->paginate(10);
        return view('super_admin.jumuiyas.index', compact('jumuiyas'));
    }

    public function createJumuiya()
    {
        return view('super_admin.jumuiyas.create');
    }

    public function storeJumuiya(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:jumuiyas',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'chairperson_name' => 'required|string|max:255',
            'chairperson_email' => 'required|email|unique:users,email',
            'chairperson_phone' => 'required|string|max:255|unique:users,phone',
        ]);

        // Create chairperson user
        $chairperson = User::create([
            'name' => $validated['chairperson_name'],
            'email' => $validated['chairperson_email'],
            'phone' => $validated['chairperson_phone'],
            'password' => Hash::make('password'), // Default password
            'role' => 'chairperson',
        ]);

        // Create Jumuiya
        $jumuiya = Jumuiya::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'chairperson_id' => $chairperson->id,
        ]);

        // Send welcome email to chairperson with credentials
        // TODO: Implement email notification

        return redirect()
            ->route('super_admin.jumuiyas.index')
            ->with('success', 'Jumuiya created successfully');
    }

    public function editJumuiya(Jumuiya $jumuiya)
    {
        return view('super_admin.jumuiyas.edit', compact('jumuiya'));
    }

    public function updateJumuiya(Request $request, Jumuiya $jumuiya)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('jumuias')->ignore($jumuiya)],
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $jumuiya->update($validated);

        return redirect()
            ->route('super_admin.jumuiyas.index')
            ->with('success', 'Jumuiya updated successfully');
    }

    public function deleteJumuiya(Jumuiya $jumuiya)
    {
        // Check if Jumuiya has members
        if ($jumuiya->members()->count() > 0) {
            return back()->with('error', 'Cannot delete Jumuiya with existing members');
        }

        // Delete chairperson user
        if ($jumuiya->chairperson) {
            $jumuiya->chairperson->delete();
        }

        // Delete Jumuiya
        $jumuiya->delete();

        return redirect()
            ->route('super_admin.jumuiyas.index')
            ->with('success', 'Jumuiya deleted successfully');
    }
}
