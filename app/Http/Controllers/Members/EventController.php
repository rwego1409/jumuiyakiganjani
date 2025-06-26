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

        if ($user->role === 'member') {
            $member = $user->member;
            if ($member && $member->jumuiya_id) {
                $jumuiyaId = $member->jumuiya_id;
                $query->where(function ($q) use ($jumuiyaId) {
                    // Events linked to the member's jumuiya
                    $q->whereHas('jumuiyas', function ($q2) use ($jumuiyaId) {
                        $q2->where('jumuiya_id', $jumuiyaId);
                    })
                    // Or global events created by admin (not linked to any jumuiya)
                    ->orWhere(function ($q3) {
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
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403);
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
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        abort(403);
    }
}
