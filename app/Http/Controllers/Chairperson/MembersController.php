<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
{
    public function index()
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya) {
            return redirect()->route('chairperson.dashboard')
                ->with('error', 'No jumuiya assigned to your account.');
        }

        $members = Member::with('user')
            ->where('jumuiya_id', $jumuiya->id)
            ->latest()
            ->paginate(10);

        $stats = [
            'total_members' => $members->total(),
            'active_members' => Member::where('jumuiya_id', $jumuiya->id)
                ->where('status', 'active')
                ->count(),
            'inactive_members' => Member::where('jumuiya_id', $jumuiya->id)
                ->where('status', 'inactive')
                ->count()
        ];

        return view('chairperson.members.index', compact('members', 'stats'));
    }

    public function show(Member $member)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya || $member->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.members.index')
                ->with('error', 'Unauthorized action.');
        }

        // Load member's recent contributions
        $recentContributions = $member->contributions()
            ->latest()
            ->take(5)
            ->get();

        return view('chairperson.members.show', compact('member', 'recentContributions'));
    }

    public function create()
    {
        // If you need to pass data (e.g., dropdowns), fetch here
        return view('chairperson.members.create');
    }

    public function edit($id)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        $member = Member::findOrFail($id);
        if (!$jumuiya || $member->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.members.index')
                ->with('error', 'Unauthorized action.');
        }
        return view('chairperson.members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        $member = Member::findOrFail($id);
        if (!$jumuiya || $member->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.members.index')
                ->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $member->user_id,
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
            'joined_date' => 'nullable|date',
        ]);

        $member->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        $member->update([
            'phone' => $validated['phone'],
            'status' => $validated['status'],
            'joined_date' => $validated['joined_date'],
        ]);

        return redirect()->route('chairperson.members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        if (!$jumuiya || $member->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.members.index')
                ->with('error', 'Unauthorized action.');
        }
        $member->delete();
        return redirect()->route('chairperson.members.index')
            ->with('success', 'Member deleted successfully.');
    }
}
