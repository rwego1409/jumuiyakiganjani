<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jumuiya;

class JumuiyasController extends Controller
{
    public function index()
    {
        $jumuiyas = Jumuiya::with('chairperson')->get();
        return view('admin.jumuiyas.index', compact('jumuiyas'));
    }

    public function show(Jumuiya $jumuiya)
    {
        $jumuiya->load(['chairperson', 'members.user', 'events', 'contributions']);
        return view('admin.jumuiyas.show', compact('jumuiya'));
    }

    public function edit(Jumuiya $jumuiya)
    {
        $chairpersons = \App\Models\User::where('role', 'chairperson')->get();
        return view('admin.jumuiyas.edit', compact('jumuiya', 'chairpersons'));
    }

    public function update(\App\Http\Requests\UpdateJumuiyaRequest $request, Jumuiya $jumuiya)
    {
        $jumuiya->update($request->validated());
        return redirect()->route('admin.jumuiyas.show', $jumuiya)->with('success', 'Jumuiya updated successfully.');
    }

    public function destroy(Jumuiya $jumuiya)
    {
        if ($jumuiya->members()->count() > 0) {
            return redirect()->route('admin.jumuiyas.index')->with('error', 'Cannot delete Jumuiya that has members.');
        }
        $jumuiya->delete();
        return redirect()->route('admin.jumuiyas.index')->with('success', 'Jumuiya deleted successfully.');
    }
}
