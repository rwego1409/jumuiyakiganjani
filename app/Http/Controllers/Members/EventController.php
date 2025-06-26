<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Jumuiya;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Event::query();

        if ($user->hasRole('member')) {
            $member = $user->member;

            if ($member && $member->jumuiya_id) {
                $jumuiyaId = $member->jumuiya_id;

                // Get IDs of chairpersons linked to the member's jumuiya
                $chairpersonIds = \App\Models\User::whereHas('jumuiyas', function($q) use ($jumuiyaId) {
                    $q->where('jumuiya_id', $jumuiyaId);
                })
                ->whereHas('roles', function($q) {
                    $q->where('name', 'chairperson');
                })
                ->pluck('id')
                ->toArray();

                $query->where(function ($q) use ($jumuiyaId, $chairpersonIds) {
                    $q->whereHas('jumuiyas', function ($q2) use ($jumuiyaId) {
                        $q2->where('jumuiya_id', $jumuiyaId);
                    });

                    if (!empty($chairpersonIds)) {
                        $q->orWhereIn('created_by', $chairpersonIds);
                    }

                    // Global events created by admins (no jumuiya)
                    $q->orWhere(function ($q3) {
                        $q3->whereDoesntHave('jumuiyas')
                           ->whereHas('creator', function ($q4) {
                               $q4->where('role', 'admin');
                           });
                    });
                });
            } else {
                // If no jumuiya, only show global admin events
                $query->whereDoesntHave('jumuiyas')
                      ->whereHas('creator', function ($q) {
                          $q->where('role', 'admin');
                      });
            }
        }

        $events = $query->with('jumuiyas', 'creator')->latest()->paginate(10);

        return view('member.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('member.events.create', [
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        Event::create([
            'jumuiya_id' => $request->jumuiya_id,
            'name' => $request->name,
            'date' => $request->date,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('member.events.index')
            ->with('success', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('member.events.show', [
            'event' => $event->load('jumuiyas', 'creator')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('member.events.edit', [
            'event' => $event,
            'jumuiyas' => Jumuiya::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        $event->update([
            'jumuiya_id' => $request->jumuiya_id,
            'name' => $request->name,
            'date' => $request->date,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('member.events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('member.events.index')
            ->with('success', 'Event deleted successfully');
    }
}
