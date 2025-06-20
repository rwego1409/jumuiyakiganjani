<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Jumuiya;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class JumuiyaController extends Controller
{
    public function index()
    {
        $jumuiyas = Jumuiya::with(['chairperson', 'members'])
            ->withCount('members')
            ->latest()
            ->paginate(10);

        return view('super_admin.jumuiyas.index', compact('jumuiyas'));
    }

    public function create()
    {
        $availableChairpersons = User::where('role', 'chairperson')
            ->whereDoesntHave('jumuiyas')
            ->get();

        return view('super_admin.jumuiyas.create', compact('availableChairpersons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:jumuiyas'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'chairperson_email' => ['required', 'email'],
            'meeting_day' => ['required', 'string', Rule::in(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])],
            'meeting_time' => ['required', 'date_format:H:i'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])]
        ]);

        DB::transaction(function () use ($validated) {
            // Find or create the chairperson user
            $user = User::where('email', $validated['chairperson_email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $validated['chairperson_email'], // You may want to split or ask for name
                    'email' => $validated['chairperson_email'],
                    'password' => bcrypt('password'), // Set a default password or send invite
                    'role' => 'chairperson',
                ]);
            } else {
                $user->update(['role' => 'chairperson']);
            }

            $jumuiyaData = $validated;
            $jumuiyaData['chairperson_id'] = $user->id;
            unset($jumuiyaData['chairperson_email']);

            Jumuiya::create($jumuiyaData);
        });

        return redirect()->route('super_admin.jumuiyas.index')
            ->with('success', 'Jumuiya created successfully.');
    }

    public function show(Jumuiya $jumuiya)
    {
        $jumuiya->load(['chairperson', 'events' => function ($query) {
            $query->latest()->take(5);
        }]);

        $members = $jumuiya->members()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $memberCount = $jumuiya->members()->count();
        $activeMembers = $jumuiya->members()->where('status', 'active')->count();
        $pendingMembers = $jumuiya->members()->where('status', 'pending')->count();

        return view('super_admin.jumuiyas.show', compact('jumuiya', 'members', 'memberCount', 'activeMembers', 'pendingMembers'));
    }

    public function edit(Jumuiya $jumuiya)
    {
        $availableChairpersons = User::where('role', 'chairperson')
            ->where(function ($query) use ($jumuiya) {
                $query->whereDoesntHave('jumuiyas')
                    ->orWhere('id', $jumuiya->chairperson_id);
            })
            ->get();

        return view('super_admin.jumuiyas.edit', compact('jumuiya', 'availableChairpersons'));
    }

    public function update(Request $request, Jumuiya $jumuiya)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('jumuiyas')->ignore($jumuiya->id)],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'chairperson_id' => ['required', 'exists:users,id'],
            'meeting_day' => ['required', 'string', Rule::in(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])],
            'meeting_time' => ['required', 'date_format:H:i'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])]
        ]);

        DB::transaction(function () use ($jumuiya, $validated) {
            // If chairperson is changed, update roles accordingly
            if ($jumuiya->chairperson_id !== $validated['chairperson_id']) {
                // Check if old chairperson has other jumuiyas
                $oldChairperson = User::find($jumuiya->chairperson_id);
                if ($oldChairperson && $oldChairperson->jumuiyas()->count() === 1) {
                    $oldChairperson->update(['role' => 'member']);
                }

                // Ensure new chairperson has chairperson role
                User::where('id', $validated['chairperson_id'])
                    ->update(['role' => 'chairperson']);
            }

            $jumuiya->update($validated);
        });

        return redirect()->route('super_admin.jumuiyas.index')
            ->with('success', 'Jumuiya updated successfully.');
    }    public function destroy(Jumuiya $jumuiya)
    {
        DB::transaction(function () use ($jumuiya) {
            // Delete all related records first in the correct order
            $jumuiya->events()->delete();
            $jumuiya->resources()->delete();
            $jumuiya->members()->delete();
            
            // Check if chairperson has other jumuiyas
            $chairperson = $jumuiya->chairperson;
            if ($chairperson && $chairperson->jumuiyas()->count() === 1) {
                $chairperson->update(['role' => 'member']);
            }

            // Finally delete the jumuiya
            $jumuiya->delete();
        });

        return redirect()->route('super_admin.jumuiyas.index')
            ->with('success', 'Jumuiya deleted successfully.');
    }
}
