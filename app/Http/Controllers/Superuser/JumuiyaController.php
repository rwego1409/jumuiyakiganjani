<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\Jumuiya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JumuiyaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_user']);
    }

    public function index()
    {
        $jumuiyas = Jumuiya::all();
        return view('superuser.jumuiyas.index', compact('jumuiyas'));
    }

    public function create()
    {
        $chairpersons = \App\Models\User::where('role', 'chairperson')->get();
        return view('superuser.jumuiyas.create', compact('chairpersons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'chairperson_id' => 'required|exists:users,id',
        ]);
        $jumuiya = \App\Models\Jumuiya::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'created_by' => auth()->id(),
        ]);
        // Assign chairperson (assuming a chairperson_id column or relationship)
        $jumuiya->chairperson_id = $validated['chairperson_id'];
        $jumuiya->save();
        return redirect()->route('superuser.jumuiyas.index')->with('success', 'Jumuiya created successfully.');
    }

    public function show(Jumuiya $jumuiya)
    {
        return view('superuser.jumuiyas.show', compact('jumuiya'));
    }
}
