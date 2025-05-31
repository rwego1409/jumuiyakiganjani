<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ChairpersonsController extends Controller
{
    public function index()
    {
        $chairpersons = User::where('role', 'chairperson')->latest()->paginate(10);
        return view('admin.chairpersons.index', compact('chairpersons'));
    }

    public function create()
    {
        return view('admin.chairpersons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $validated['role'] = 'chairperson';
        $validated['password'] = Hash::make($validated['password']);
        $chairperson = User::create($validated);
        return redirect()->route('admin.chairpersons.index')->with('success', 'Chairperson created successfully');
    }

    public function show(User $chairperson)
    {
        if ($chairperson->role !== 'chairperson') abort(404);
        return view('admin.chairpersons.show', compact('chairperson'));
    }

    public function edit(User $chairperson)
    {
        if ($chairperson->role !== 'chairperson') abort(404);
        return view('admin.chairpersons.edit', compact('chairperson'));
    }

    public function update(Request $request, User $chairperson)
    {
        if ($chairperson->role !== 'chairperson') abort(404);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email',Rule::unique('users')->ignore($chairperson->id)],
            'phone' => ['required','string','max:255',Rule::unique('users')->ignore($chairperson->id)],
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $chairperson->update($validated);
        return redirect()->route('admin.chairpersons.index')->with('success', 'Chairperson updated successfully');
    }

    public function destroy(User $chairperson)
    {
        if ($chairperson->role !== 'chairperson') abort(404);
        $chairperson->delete();
        return redirect()->route('admin.chairpersons.index')->with('success', 'Chairperson deleted successfully');
    }
}

