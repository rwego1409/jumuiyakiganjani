<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contribution;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContributionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Paginate the contributions (adjust the number to your preference, e.g., 10)
        $contributions = Contribution::with('member')->paginate(10);
    
        return view('admin.contributions.index', compact('contributions'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all members from the database
        $members = Member::with('user')->get();

        // Define options for select dropdown
        $options = [
            'option1' => 'Option 1',
            'option2' => 'Option 2',
            'option3' => 'Option 3',
        ];

        // Return the create view with members and options
        return view('admin.contributions.create', compact('members', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'member_id' => 'required|integer',
            'jumuiya_id' => 'required|integer',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        // Store the new contribution in the database
        Contribution::create($request->all());

        // Redirect to the contributions index with success message
        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::findOrFail($id);

        // Return the show view with the contribution data
        return view('admin.contributions.show', compact('contribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::findOrFail($id);

        // Fetch all members from the database
        $members = Member::with('user')->get();

        // Define options for select dropdown
        $options = [
            'option1' => 'Option 1',
            'option2' => 'Option 2',
            'option3' => 'Option 3',
        ];

        // Return the edit view with contribution data, members, and options
        return view('admin.contributions.edit', compact('contribution', 'members', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request
        $request->validate([
            'member_id' => 'required|integer',
            'jumuiya_id' => 'required|integer',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        // Find the contribution by ID and update it
        $contribution = Contribution::findOrFail($id);
        $contribution->update($request->all());

        // Redirect to the contributions index with success message
        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the contribution by ID and delete it
        $contribution = Contribution::findOrFail($id);
        $contribution->delete();

        // Redirect to the contributions index with success message
        return redirect()->route('admin.contributions.index')
            ->with('success', 'Contribution deleted successfully');
    }
}
