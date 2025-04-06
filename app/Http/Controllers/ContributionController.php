<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContributionRequest;
use App\Http\Requests\UpdateContributionRequest;
use App\Models\Contribution;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.contributions.index', [
            'contributions' => Contribution::with(['member', 'jumuiya'])->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contributions.create', [
            'members' => Member::with(['user'])->get(),
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContributionRequest $request)
    {
        Contribution::create([
            'member_id' => $request->member_id,
            'jumuiya_id' => $request->jumuiya_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'status' => $request->status
        ]);

        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        return view('admin.contributions.show', [
            'contribution' => $contribution->load(['member', 'jumuiya'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution)
    {
        return view('admin.contributions.edit', [
            'contribution' => $contribution->load(['member', 'jumuiya']),
            'members' => Member::with(['user'])->get(),
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContributionRequest $request, Contribution $contribution)
    {
        $contribution->update([
            'member_id' => $request->member_id,
            'jumuiya_id' => $request->jumuiya_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'status' => $request->status
        ]);

        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        $contribution->delete();

        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution deleted successfully');
    }
}
