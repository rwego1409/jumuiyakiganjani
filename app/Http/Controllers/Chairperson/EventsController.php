<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Jumuiya;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if user can view events
        $this->authorize('viewAny', Event::class);

        $user = auth()->user();
        Log::info('EventsController@index user', [
            'id' => $user->id,
            'role' => $user->role,
            'jumuiya_ids' => $user->jumuiyas->pluck('id'),
            'member_jumuiya_id' => optional($user->member)->jumuiya_id
        ]);

        $query = Event::with(['creator', 'jumuiyas']);

        if ($user->hasRole('chairperson')) {
            $jumuiya = $user->jumuiyas()->first();
            Log::info('Chairperson jumuiya', ['jumuiya' => $jumuiya]);

            if ($jumuiya) {
                $query->where(function ($q) use ($jumuiya, $user) {
                    $q->whereHas('jumuiyas', function ($q2) use ($jumuiya) {
                        $q2->where('jumuiya_id', $jumuiya->id);
                    })
                    ->orWhere('created_by', $user->id)
                    ->orWhereHas('creator', function ($q2) {
                        $q2->where('role', 'admin');
                    });
                });
            }
        } elseif ($user->hasRole('member')) {
            $member = $user->member;
            Log::info('Member info', ['member' => $member]);

            if ($member && $member->jumuiya_id) {
                $query->where(function ($q) use ($member) {
                    $q->whereHas('jumuiyas', function ($q2) use ($member) {
                        $q2->where('jumuiya_id', $member->jumuiya_id);
                    })
                    ->orWhereHas('creator', function ($q2) {
                        $q2->where('role', 'admin');
                    });
                });
            }
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_time', '<=', $request->end_date);
        }

        $events = $query->latest()->paginate(10);

        Log::info('EventsController@index events count', [
            'count' => $events->count(), 
            'event_ids' => $events->pluck('id')
        ]);

        return view('chairperson.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user can create events
        $this->authorize('create', Event::class);
        
        return view('chairperson.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user can create events
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed'
        ]);

        $jumuiya = auth()->user()->jumuiyas()->first();
        if (!$jumuiya) {
            return redirect()->route('chairperson.events.index')
                ->with('error', 'No jumuiya assigned to your account.');
        }

        $validated['created_by'] = auth()->id();
        $validated['title'] = $validated['name'];
        unset($validated['name']);

        $event = Event::create($validated);
        $event->jumuiyas()->attach($jumuiya->id);
        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'description' => 'Created event: ' . $event->title,
            'model_type' => Event::class,
            'model_id' => $event->id,
            'properties' => $event->toArray(),
        ]);

        Log::info('Event created by chairperson', [
            'event_id' => $event->id,
            'created_by' => $event->created_by,
            'creator_id' => auth()->id(),
            'jumuiya_id' => $jumuiya->id
        ]);

        return redirect()->route('chairperson.events.show', $event)
            ->with('success', __('Event created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // Check if user can view this specific event
        $this->authorize('view', $event);
        
        return view('chairperson.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // Laravel will automatically check EventPolicy::update()
        // This will throw an authorization exception if not allowed
        try {
            $this->authorize('update', $event);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            // Check if it's an admin event for better error message
            if (optional($event->creator)->role === 'admin') {
                return redirect()->route('chairperson.events.index')
                    ->with('error', 'This event was created by admin. Please contact admin to edit it.');
            }
            
            return redirect()->route('chairperson.events.index')
                ->with('error', 'You are not authorized to edit this event.');
        }
        
        Log::info('Edit authorized', [
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'event_created_by' => $event->created_by
        ]);

        return view('chairperson.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Laravel will automatically check EventPolicy::update()
        try {
            $this->authorize('update', $event);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            // Check if it's an admin event for better error message
            if (optional($event->creator)->role === 'admin') {
                return redirect()->route('chairperson.events.index')
                    ->with('error', 'This event was created by admin. Please contact admin to edit it.');
            }
            
            return redirect()->route('chairperson.events.index')
                ->with('error', 'You are not authorized to update this event.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed'
        ]);

        $validated['title'] = $validated['name'];
        unset($validated['name']);
        
        $event->update($validated);
        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'description' => 'Updated event: ' . $event->title,
            'model_type' => Event::class,
            'model_id' => $event->id,
            'properties' => $event->toArray(),
        ]);

        Log::info('Event updated successfully', [
            'event_id' => $event->id,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('chairperson.events.show', $event)
            ->with('success', __('Event updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Laravel will automatically check EventPolicy::delete()
        try {
            $this->authorize('delete', $event);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            // Check if it's an admin event for better error message
            if (optional($event->creator)->role === 'admin') {
                return redirect()->route('chairperson.events.index')
                    ->with('error', 'This event was created by admin. Please contact admin to delete it.');
            }
            
            return redirect()->route('chairperson.events.index')
                ->with('error', 'You are not authorized to delete this event.');
        }
        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'description' => 'Deleted event: ' . $event->title,
            'model_type' => Event::class,
            'model_id' => $event->id,
            'properties' => $event->toArray(),
        ]);
        $eventId = $event->id;
        $event->delete();

        Log::info('Event deleted successfully', [
            'event_id' => $eventId,
            'deleted_by' => auth()->id()
        ]);

        return redirect()->route('chairperson.events.index')
            ->with('success', __('Event deleted successfully.'));
    }
}