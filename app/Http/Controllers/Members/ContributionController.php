<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Jumuiya;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreContributionRequest;
use App\Http\Requests\UpdateContributionRequest;
use App\Services\PaymentService;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = Auth::user()->member;

        $contributions = Contribution::with('jumuiya')
            ->where('member_id', $member->id)
            ->latest()
            ->paginate(10);

        return view('member.contributions.index', compact('contributions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jumuiyas = Jumuiya::all();

        return view('member.contributions.create', compact('jumuiyas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContributionRequest $request)
    {
        $member = Auth::user()->member;
    
        Contribution::create([
            'member_id' => $member->id,
            'jumuiya_id' => $request->jumuiya_id,
            'amount' => $request->amount,
            'contribution_date' => $request->contribution_date,
            'status' => 'pending', // default status
        ]);
    
        return redirect()->route('member.contributions.index')
            ->with('success', 'Contribution created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        // Optional: Authorize view access
        $this->authorize('view', $contribution);

        return view('member.contributions.show', [
            'contribution' => $contribution->load(['member', 'jumuiya'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution)
    {
        // Optional: Authorize edit access
        $this->authorize('update', $contribution);

        $jumuiyas = Jumuiya::all();

        return view('member.contributions.edit', compact('contribution', 'jumuiyas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContributionRequest $request, Contribution $contribution)
    {
        // Optional: Authorize update access
        $this->authorize('update', $contribution);

        $contribution->update([
            'jumuiya_id' => $request->jumuiya_id,
            'amount' => $request->amount,
            'contribution_date' => $request->contribution_date,
            'status' => $request->status ?? 'pending'
        ]);

        return redirect()->route('member.contributions.index')
            ->with('success', 'Contribution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        // Optional: Authorize delete access
        $this->authorize('delete', $contribution);

        $contribution->delete();

        return redirect()->route('member.contributions.index')
            ->with('success', 'Contribution deleted successfully.');
    }

    /**
     * Handle the payment of a contribution.
     */
    public function payContribution($id, PaymentService $paymentService)
    {
        $contribution = Contribution::where('id', $id)
            ->where('member_id', auth()->user()->member->id)
            ->firstOrFail();

        // Simulate payment process or call actual payment service
        $paymentStatus = $paymentService->processPayment($contribution);

        if ($paymentStatus['status'] == 'success') {
            // Update the contribution status after successful payment
            $contribution->update([
                'status' => 'paid',
                'payment_date' => now(),
                'payment_method' => $paymentStatus['method'],
            ]);

            return redirect()->route('member.contributions.index')
                ->with('success', 'Payment successful. Thank you!');
        } else {
            return redirect()->route('member.contributions.index')
                ->with('error', 'Payment failed. Please try again later.');
        }
    }

    /**
     * Display the payment history of the member.
     */
    public function paymentHistory()
    {
        $member = Auth::user()->member;

        $contributions = Contribution::with('jumuiya')
            ->where('member_id', $member->id)
            ->where('status', 'paid')
            ->latest()
            ->paginate(10);

        return view('member.contributions.payment_history', compact('contributions'));
    }

    /**
     * Show the payment status of a specific contribution.
     */
    public function paymentStatus($id)
    {
        $contribution = Contribution::with('jumuiya')
            ->where('id', $id)
            ->where('member_id', auth()->user()->member->id)
            ->firstOrFail();

        return view('member.contributions.payment_status', compact('contribution'));
    }

    /**
     * Show the payment receipt of a specific contribution.
     */
    public function paymentReceipt($id)
    {
        $contribution = Contribution::with('jumuiya')
            ->where('id', $id)
            ->where('member_id', auth()->user()->member->id)
            ->firstOrFail();

        return view('member.contributions.payment_receipt', compact('contribution'));
    }
}
