<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::acceptingDonations()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.donation.index', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:gcash,bank_transfer,cash',
            'proof_of_payment' => 'required|image|max:2048'
        ]);

        $campaign = Campaign::findOrFail($request->campaign_id);

        // Check if campaign is still accepting donations
        if (!$campaign->isAcceptingDonations()) {
            return redirect()->back()
                ->withErrors(['campaign_id' => 'This campaign is no longer accepting donations.'])
                ->withInput();
        }

        // Handle file upload
        $path = $request->file('proof_of_payment')->store('donation_proofs', 'public');

        // Create donation record
        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'proof_of_payment' => $path,
            'status' => 'pending'
        ]);

        // Update campaign total donations
        $campaign->updateTotalDonations();

        return redirect()->route('donation.success')->with('success', 'Thank you for your donation! Your contribution is pending approval.');
    }

    public function success()
    {
        return view('student.donation.success');
    }
} 