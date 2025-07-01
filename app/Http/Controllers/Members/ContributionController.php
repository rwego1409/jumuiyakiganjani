<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Jumuiya;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreContributionRequest;
use App\Http\Requests\UpdateContributionRequest;
use App\Services\ClickPesaService;  // Updated to use ClickPesaService
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    protected ClickPesaService $clickPesaService;

    public function __construct(ClickPesaService $clickPesaService)
    {
        $this->clickPesaService = $clickPesaService;
    }

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
            'user_id' => Auth::id(),
            'member_id' => $member->id,
            'jumuiya_id' => $request->jumuiya_id,
            'amount' => $request->amount,
            'contribution_date' => $request->contribution_date,
            'status' => 'pending', // default status
            'recorded_by' => Auth::id(),
        ]);

        return redirect()->route('member.contributions.index')
            ->with('success', 'Contribution created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        return view('member.contributions.show', compact('contribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution)
    {
        $this->authorize('update', $contribution);

        $jumuiyas = Jumuiya::all();

        return view('member.contributions.edit', compact('contribution', 'jumuiyas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContributionRequest $request, Contribution $contribution)
    {
        $this->authorize('update', $contribution);

        $contribution->update([
            'jumuiya_id' => $request->jumuiya_id,
            'amount' => $request->amount,
            'contribution_date' => $request->contribution_date,
            'status' => $request->status ?? 'pending',
        ]);

        return redirect()->route('member.contributions.index')
            ->with('success', 'Contribution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        $this->authorize('delete', $contribution);

        $contribution->delete();

        return redirect()->route('member.contributions.index')
            ->with('success', 'Contribution deleted successfully.');
    }

    /**
     * Handle the payment of a contribution using ClickPesaService.
     */
    public function payContribution($id)
    {
        $contribution = Contribution::where('id', $id)
            ->where('member_id', auth()->user()->member->id)
            ->firstOrFail();

        // Use ClickPesaService to initiate payment
        $response = $this->clickPesaService->initiatePayment(
            auth()->user()->phone,  // Assuming user model has phone number
            $contribution->amount,
            'contrib_' . $contribution->id  // Unique reference
        );

        if ($response['success']) {
            // Optionally update contribution with payment initiation info
            $contribution->update([
                'status' => 'payment_initiated',
                'payment_reference' => $response['transaction_id'] ?? null,
            ]);

            // Redirect user to payment gateway to complete payment
            return redirect()->away($response['gateway_url']);
        } else {
            return redirect()->route('member.contributions.index')
                ->with('error', $response['error'] ?? 'Payment initiation failed. Please try again.');
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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function history($id)
    {
        $contribution = Contribution::with(['jumuiya', 'user', 'payments'])->findOrFail($id);
        return view('member.contributions.history', compact('contribution'));
    }

    /**
     * Initiate ClickPesa payment.
     */
    public function initiateClickPesa(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'phone' => 'required|regex:/^255\d{9}$/',
            'contribution_id' => 'required|exists:contributions,id'
        ]);

        $reference = 'CP-' . \Illuminate\Support\Str::random(12);

        // Create a pending payment record
        $payment = \App\Models\Payment::create([
            'reference' => $reference,
            'amount' => $validated['amount'],
            'status' => 'pending',
            'user_id' => auth()->id(),
            'contribution_id' => $validated['contribution_id'],
        ]);

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . env('CLICKPESA_API_KEY')
        ])->post(env('CLICKPESA_BASE_URL').'/v1/payments/hosted', [
            'amount' => $validated['amount'] * 100,
            'currency' => 'TZS',
            'reference' => $reference,
            'callback_url' => url('/clickpesa/callback'),
            'success_url' => route('member.contributions.index'),
            'customer' => [
                'phone' => $validated['phone'],
                'email' => auth()->user()->email
            ]
        ]);

        if ($response->successful() && isset($response->json()['checkout_url'])) {
            return redirect($response->json()['checkout_url']);
        }

        return back()->with('error', 'Payment initiation failed');
    }
}
