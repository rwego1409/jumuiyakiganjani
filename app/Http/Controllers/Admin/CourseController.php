<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contribution;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'default_amount' => 'required|numeric|min:0',
        'due_date' => 'required|date|after:today'
    ]);

    $course = Course::create($validated);

    // Assign to all active members
    $members = Member::where('status', 'active')->get();
    foreach ($members as $member) {
        $member->contributions()->create([
            'course_id' => $course->id,
            'amount' => $course->default_amount,
            'due_date' => $course->due_date
        ]);
    }

    return redirect()->route('admin.courses.index')
        ->with('success', 'Course created and assigned to members!');
}

    /**
     * Display the specified resource.
     */
    public function show(Jumuiya $jumuiya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jumuiya $jumuiya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJumuiyaRequest $request, Jumuiya $jumuiya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jumuiya $jumuiya)
    {
        //
    }
}
