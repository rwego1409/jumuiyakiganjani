<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Jumuiya;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('jumuiya')->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jumuiyas = Jumuiya::all();
        return view('admin.events.create', compact('jumuiyas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jumuiya_ids' => 'required|array|min:1',
            'jumuiya_ids.*' => 'exists:jumuiyas,id|distinct',
        ]);

        $jumuiyaIds = $validated['jumuiya_ids'];
        if (in_array('all', $jumuiyaIds)) {
            $jumuiyaIds = Jumuiya::pluck('id')->toArray();
        }
        unset($validated['jumuiya_ids']);

        $event = Event::create($validated);
        $event->jumuiyas()->sync($jumuiyaIds);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $event = Event::with(['jumuiya', 'attendees'])->findOrFail($id);
    return view('admin.events.show', compact('event'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $jumuiyas = Jumuiya::all();
        return view('admin.events.edit', compact('event', 'jumuiyas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jumuiya_ids' => 'required|array|min:1',
            'jumuiya_ids.*' => 'exists:jumuiyas,id|distinct',
        ]);

        $jumuiyaIds = $validated['jumuiya_ids'];
        if (in_array('all', $jumuiyaIds)) {
            $jumuiyaIds = Jumuiya::pluck('id')->toArray();
        }
        unset($validated['jumuiya_ids']);

        $event->update($validated);
        $event->jumuiyas()->sync($jumuiyaIds);

        return redirect()->route('admin.events.show', $event->id)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}