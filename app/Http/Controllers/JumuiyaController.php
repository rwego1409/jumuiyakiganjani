<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJumuiyaRequest;
use App\Http\Requests\UpdateJumuiyaRequest;
use App\Models\Jumuiya;
use App\Models\User;

class JumuiyaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumuiyas = Jumuiya::with(['chairperson', 'members'])->latest()->paginate(10);
        return view('admin.jumuiyas.index', compact('jumuiyas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chairpersons = User::where('role', 'chairperson')->get();
        return view('admin.jumuiyas.create', compact('chairpersons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJumuiyaRequest $request)
    {
        $jumuiya = Jumuiya::create($request->validated());

        return redirect()
            ->route('admin.jumuiyas.index')
            ->with('success', 'Jumuiya created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jumuiya $jumuiya)
    {
        $jumuiya->load(['chairperson', 'members', 'events', 'contributions']);
        return view('admin.jumuiyas.show', compact('jumuiya'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jumuiya $jumuiya)
    {
        $chairpersons = User::where('role', 'chairperson')->get();
        return view('admin.jumuiyas.edit', compact('jumuiya', 'chairpersons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJumuiyaRequest $request, Jumuiya $jumuiya)
    {
        $jumuiya->update($request->validated());

        return redirect()
            ->route('admin.jumuiyas.index')
            ->with('success', 'Jumuiya updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jumuiya $jumuiya)
    {
        // Don't allow deletion if there are members
        if ($jumuiya->members()->count() > 0) {
            return redirect()
                ->route('admin.jumuiyas.index')
                ->with('error', 'Cannot delete Jumuiya that has members.');
        }

        $jumuiya->delete();

        return redirect()
            ->route('admin.jumuiyas.index')
            ->with('success', 'Jumuiya deleted successfully.');
    }
}
