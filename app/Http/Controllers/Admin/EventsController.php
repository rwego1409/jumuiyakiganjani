<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Jumuiya;
use App\Models\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only show events created by admin (not by chairperson)
        $events = Event::with('jumuiya')
            ->whereHas('creator', function($q) {
                $q->where('role', 'admin');
            })
            ->latest()
            ->paginate(10);
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
        $data = $request->all();
        if (isset($data['jumuiya_ids']) && in_array('all', $data['jumuiya_ids'])) {
            $data['jumuiya_ids'] = Jumuiya::pluck('id')->toArray();
            $request->merge(['jumuiya_ids' => $data['jumuiya_ids']]);
        }
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
        unset($validated['jumuiya_ids']);
        $validated['created_by'] = auth()->id();
        $event = Event::create($validated);
        $event->jumuiyas()->sync($jumuiyaIds);
        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'description' => 'Created event: ' . $event->title,
            'model_type' => Event::class,
            'model_id' => $event->id,
            'properties' => $event->toArray(),
            'activity_type' => 'event',
            'loggable_type' => Event::class,
            'loggable_id' => $event->id,
        ]);

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
        // Only allow editing if event was created by admin
        if ($event->creator && $event->creator->role !== 'admin') {
            abort(403, 'You are not authorized to edit this event.');
        }
        $this->authorize('update', $event);
        $jumuiyas = Jumuiya::all();
        return view('admin.events.edit', compact('event', 'jumuiyas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);
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
        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'description' => 'Updated event: ' . $event->title,
            'model_type' => Event::class,
            'model_id' => $event->id,
            'properties' => $event->toArray(),
        ]);
        return redirect()->route('admin.events.show', $event->id)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        // Only allow deleting if event was created by admin
        if ($event->creator && $event->creator->role !== 'admin') {
            abort(403, 'You are not authorized to delete this event.');
        }
        $this->authorize('delete', $event);
        // Log activity before delete
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'description' => 'Deleted event: ' . $event->title,
            'model_type' => Event::class,
            'model_id' => $event->id,
            'properties' => $event->toArray(),
            'activity_type' => 'event',
            'loggable_type' => Event::class,
            'loggable_id' => $event->id,
        ]);
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}