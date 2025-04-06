<?php

namespace App\Http\Controllers\Admin;
use App\Models\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    protected $casts = [
        'start_time' => 'datetime',  // Cast the start_time to Carbon instance
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch events from the database as a collection
        $events = Event::paginate(10);  // or Event::all() if no pagination is required
    
        return view('admin.events.index', compact('events'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show a form to create a new event
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the event
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jumuiya_id' => 'required|exists:jumuiyas,id',  // If jumuiya_id is a foreign key
        ]);
    
        // Store the event in the database
        $event = Event::create([
            'title' => $request->title,
            'status' => $request->status,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'description' => $request->description,
            'jumuiya_id' => auth()->user()->id,  // Assuming it’s related to the authenticated user
        ]);
    
        // Redirect with success message
        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the event by ID
        // $event = Event::findOrFail($id);

        // Return a view to display the event
        return view('admin.events.show', [
            'event' => [] // Replace with actual data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the event
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean'
        ]);

        // Update the event in the database
        // $event = Event::findOrFail($id);
        // $event->update($request->all());

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the event from the database
        // $event = Event::findOrFail($id);
        // $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully');
    }
}
