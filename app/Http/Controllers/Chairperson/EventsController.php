<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Jumuiya;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_time', '<=', $request->end_date);
        }

        // Get the filtered events with pagination
        $events = $query->latest()->paginate(10);

        return view('chairperson.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chairperson.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed'
        ]);

        $event = Event::create($validated);

        return redirect()->route('chairperson.events.show', $event)
            ->with('success', __('Event created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('chairperson.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('chairperson.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed'
        ]);

        $event->update($validated);

        return redirect()->route('chairperson.events.show', $event)
            ->with('success', __('Event updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('chairperson.events.index')
            ->with('success', __('Event deleted successfully.'));
    }
}
