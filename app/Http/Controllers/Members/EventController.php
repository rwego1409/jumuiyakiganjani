<?php

namespace App\Http\Controllers\Members;
use App\Http\Controllers\Controller;
use App\Models\Jumuiya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreJumuiyaRequest;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Member;
use App\Models\Notification;
use App\Models\User;
use App\Models\Contribution;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         // Ensure no filters are applied, and fetch all events
         $events = Event::with('jumuiya')->latest()->paginate(10);  // Pagination enabled
         // If you want all events without pagination, use ->get() instead
         // $events = Event::with('jumuiya')->latest()->get();
     
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
    public function store(StoreEventRequest $request)
    {
        Event::create([
            'jumuiya_id' => $request->jumuiya_id,
            'name' => $request->name,
            'date' => $request->date,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status
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
            'event' => $event->load(['jumuiya'])
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
