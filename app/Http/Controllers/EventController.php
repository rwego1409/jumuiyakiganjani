<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.events.index', [
            'events' => Event::with(['jumuiya'])->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create', [
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        Event::create([
            'jumuiya_id' => $request->jumuiya_id,
            'name' => $request->name,
            'date' => $request->date,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', [
            'event' => $event->load(['jumuiya'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', [
            'event' => $event,
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update([
            'jumuiya_id' => $request->jumuiya_id,
            'name' => $request->name,
            'date' => $request->date,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully');
    }
}
