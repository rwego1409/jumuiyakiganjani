<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Member;
use App\Models\Activity;
use App\Traits\JumuiyaAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ContributionsController extends Controller
{
    use JumuiyaAccess;
    public function index()
    {
        $this->authorize('viewAny', Contribution::class);
        
        $jumuiya = $this->getChairpersonJumuiya();
        if (!$jumuiya) {
            return redirect()->route('chairperson.dashboard')
                ->with('error', 'No jumuiya assigned to your account.');
        }

        $jumuiyaId = $jumuiya->id;
        $cacheKey = "jumuiya_{$jumuiyaId}_contributions";
        
        $contributions = Contribution::with(['member.user'])
            ->where('jumuiya_id', $jumuiyaId)
            ->latest()
            ->paginate(10);

        $statsKey = "jumuiya_{$jumuiyaId}_contribution_stats";
        $stats = [
            'total_amount' => Contribution::where('jumuiya_id', $jumuiyaId)->sum('amount'),
            'total_contributions' => Contribution::where('jumuiya_id', $jumuiyaId)->count(),
            'pending_contributions' => Contribution::where('jumuiya_id', $jumuiyaId)->count()
        ];

        return view('chairperson.contributions.index', compact('contributions', 'stats'));
    }

    public function create()
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'No jumuiya assigned to your account.');
        }

        $members = Member::where('jumuiya_id', $jumuiya->id)
            ->with('user')
            ->get();

        return view('chairperson.contributions.create', compact('members'));
    }

    public function store(Request $request)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'No jumuiya assigned to your account.');
        }

        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'contribution_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,mobile,bank'],
            'purpose' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,confirmed,rejected']
        ]);

        // Verify the member belongs to the chairperson's jumuiya
        $member = Member::findOrFail($validated['member_id']);
        if ($member->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'Unauthorized action.');
        }

        $validated['jumuiya_id'] = $jumuiya->id;
        $validated['recorded_by'] = Auth::id();
        $validated['user_id'] = $member->user_id;
        $validated['payment_reference'] = \Illuminate\Support\Str::uuid();

        $contribution = Contribution::create($validated);
        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created contribution: ' . ($contribution->id ?? ''),
            'model_type' => Contribution::class,
            'model_id' => $contribution->id,
            'properties' => $contribution->toArray(),
        ]);

        return redirect()->route('chairperson.contributions.index')
            ->with('success', 'Contribution recorded successfully.');
    }

    public function show(Contribution $contribution)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya || $contribution->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'Unauthorized action.');
        }

        return view('chairperson.contributions.show', compact('contribution'));
    }

    public function edit(Contribution $contribution)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya || $contribution->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'Unauthorized action.');
        }

        $members = Member::where('jumuiya_id', $jumuiya->id)
            ->with('user')
            ->get();

        // Fetch all contributions for this member for cashbook ledger
        $cashbook = Contribution::where('member_id', $contribution->member_id)
            ->orderBy('contribution_date')
            ->get();

        // Do not allow editing of the contribution itself
        return view('chairperson.contributions.edit', compact('contribution', 'members', 'cashbook'));
    }

    public function update(Request $request, Contribution $contribution)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya || $contribution->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'contribution_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,mobile,bank'],
            'purpose' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,confirmed,rejected']
        ]);

        // Verify the member belongs to the chairperson's jumuiya
        $member = Member::findOrFail($validated['member_id']);
        if ($member->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'Unauthorized action.');
        }

        $contribution->update($validated);
        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated contribution: ' . $contribution->id,
            'model_type' => Contribution::class,
            'model_id' => $contribution->id,
            'properties' => $contribution->toArray(),
        ]);

        return redirect()->route('chairperson.contributions.index')
            ->with('success', 'Contribution updated successfully.');
    }

    public function destroy(Contribution $contribution)
    {
        $jumuiya = Auth::user()->jumuiyas()->first();
        
        if (!$jumuiya || $contribution->jumuiya_id !== $jumuiya->id) {
            return redirect()->route('chairperson.contributions.index')
                ->with('error', 'Unauthorized action.');
        }

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted contribution: ' . $contribution->id,
            'model_type' => Contribution::class,
            'model_id' => $contribution->id,
            'properties' => $contribution->toArray(),
        ]);
        $contribution->delete();

        return redirect()->route('chairperson.contributions.index')
            ->with('success', 'Contribution deleted successfully.');
    }
}
