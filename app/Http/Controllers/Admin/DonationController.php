<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonetaryDonationReceived;
use App\Mail\NonMonetaryDropoffConfirmed;
use Illuminate\Support\Facades\Log;
use App\Models\Donor;
use App\Mail\NonMonetaryReceivedConfirmation;
use App\Mail\NonMonetaryRejected;
use App\Mail\NonMonetaryRescheduled;
use App\Mail\DonationRejectedWithReason;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        // If the URL contains /all, redirect to /all-donors
        if ($request->is('admin/donations/all')) {
            return redirect()->route('admin.donations.all-donors');
        }

        // Get current month's data
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Get total monetary donations - use effective amount (confirmed_amount if edited, otherwise amount)
        $monetaryTotal = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->get()
            ->sum('effective_amount');

        // Calculate monetary change
        $lastMonthMonetary = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->get()
            ->sum('effective_amount');
        
        $monetaryChange = $lastMonthMonetary > 0 
            ? (($monetaryTotal - $lastMonthMonetary) / $lastMonthMonetary) * 100 
            : 0;

        // Get count of non-monetary donations
        $nonMonetaryCount = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->count();

        // Calculate non-monetary change
        $lastMonthNonMonetary = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        $nonMonetaryChange = $lastMonthNonMonetary > 0 
            ? (($nonMonetaryCount - $lastMonthNonMonetary) / $lastMonthNonMonetary) * 100 
            : 0;

        // Get total campaigns count
        $totalCampaigns = Campaign::count();

        // Get campaign total and change (using existing logic, but now linked to $totalCampaigns) - use effective amount
        $campaignTotal = Donation::whereHas('campaign', function($query) {
                $query->where('status', 'active');
            })
            ->where('status', 'approved')
            ->get()
            ->sum('effective_amount');

        $lastMonthCampaign = Donation::whereHas('campaign', function($query) use ($lastMonth) {
                $query->where('status', 'active');
            })
            ->where('status', 'approved')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->get()
            ->sum('effective_amount');
        
        $campaignChange = $lastMonthCampaign > 0 
            ? (($campaignTotal - $lastMonthCampaign) / $lastMonthCampaign) * 100 
            : 0;

        // Get donor count and change (count actual received donations by unique donor names)
        // For monetary: approved and completed are both valid (payment received)
        // For non-monetary: only completed is valid (items physically received)
        $donorCount = Donation::where(function($query) {
            $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
        })->orWhere(function($query) {
            $query->where('type', 'non-monetary')->where('status', 'completed');
        })->distinct('donor_name')->count('donor_name');

        $lastMonthDonors = Donation::where(function($query) use ($lastMonth) {
            $query->where('type', 'monetary')
                  ->whereIn('status', ['approved', 'completed'])
                  ->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year);
        })->orWhere(function($query) use ($lastMonth) {
            $query->where('type', 'non-monetary')
                  ->where('status', 'completed')
                  ->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year);
        })->distinct('donor_name')->count('donor_name');
        
        $donorChange = $lastMonthDonors > 0 
            ? (($donorCount - $lastMonthDonors) / $lastMonthDonors) * 100 
            : 0;

        // Query for recent donations (no filter/search on index page)
        $donations = Donation::with(['campaign', 'urgentCampaign'])->latest()->limit(5)->get();

        // Get pending drop-offs for the new section
        $pendingDonationsQuery = Donation::with(['campaign', 'urgentCampaign'])->where('status', 'pending')->latest();

        if ($request->has('search_dashboard_pending')) {
            $search = $request->input('search_dashboard_pending');
            $pendingDonationsQuery->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', '%' . $search . '%')
                    ->orWhere('donor_email', 'like', '%' . $search . '%')
                    ->orWhere('item_name', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        $pendingDonations = $pendingDonationsQuery->take(5)->get();

        // Get pending drop-offs (approved donations awaiting physical drop-off)
        // Sort by expected_date ascending (soonest drop-offs first), then by created_at for items without expected_date
        $pendingDropoffs = Donation::where('type', 'non-monetary')
            ->where('status', 'approved')
            ->orderByRaw('expected_date IS NULL, expected_date ASC, created_at ASC')
            ->take(5)
            ->get();

        return view('admin.donation.index', compact(
            'monetaryTotal',
            'monetaryChange',
            'nonMonetaryCount',
            'nonMonetaryChange',
            'totalCampaigns',
            'campaignTotal',
            'campaignChange',
            'donorCount',
            'donorChange',
            'donations',
            'pendingDonations',
            'pendingDropoffs'
        ));
    }

    // public function create()
    // {
    //     $campaigns = Campaign::where('status', 'active')->get();
    //     return view('admin.donation.create', compact('campaigns'));
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'type' => 'required|in:monetary,non-monetary',
    //         'donor_name' => 'required|string|max:255',
    //         'donor_email' => 'required|email|max:255',
    //         'campaign_id' => 'nullable|exists:campaigns,id',
    //         'amount' => 'required_if:type,monetary|numeric|min:0',
    //         'item_name' => 'required_if:type,non-monetary|string|max:255',
    //         'quantity' => 'required_if:type,non-monetary|integer|min:1',
    //         'expected_date' => 'required_if:type,non-monetary|date|after:today',
    //         'notes' => 'nullable|string',
    //         'category' => 'required_if:type,non-monetary|nullable|string|max:255',
    //         'condition' => 'required_if:type,non-monetary|nullable|string|max:255',
    //     ]);

    //     $donation = Donation::create($validated);

    //     // For monetary donations
    //     if ($request->hasFile('proof')) {
    //         $proofPath = $request->file('proof')->store('proofs', 'public');
    //         $donation->update(['proof_path' => $proofPath]);
    //     }

    //     // For non-monetary donations
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('non-monetary-donations', 'public');
    //         $donation->update(['image_path' => $imagePath]);
    //     }

    //     return redirect()
    //         ->route('admin.donations.show', $donation)
    //         ->with('success', 'Donation created successfully.');
    // }

    public function show(Donation $donation)
    {
        return view('admin.donation.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $campaigns = Campaign::acceptingDonations()->get();
        return view('admin.donations.adddonation', compact('donation', 'campaigns'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'type' => 'required|in:monetary,non-monetary',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'amount' => 'required_if:type,monetary|numeric|min:0',
            'item_name' => 'required_if:type,non-monetary|string|max:255',
            'quantity' => 'required_if:type,non-monetary|string',
            'expected_date' => 'required_if:type,non-monetary|date|after:today',
            'notes' => 'nullable|string',
            'category' => 'required_if:type,non-monetary|nullable|string|max:255',
        ]);

        // Store old values for comparison
        $oldCampaignId = $donation->campaign_id;
        $oldAmount = $donation->amount;
        $oldType = $donation->type;

        $donation->update($validated);

        // For monetary donations
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
            $donation->update(['proof_path' => $proofPath]);
        }

        // For non-monetary donations
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('non-monetary-donations', 'public');
            $donation->update(['image_path' => $imagePath]);
        }

        // Update campaign totals if monetary donation details changed
        if ($donation->type === 'monetary' && $donation->status === 'completed') {
            // Update old campaign if it changed
            if ($oldCampaignId && $oldCampaignId !== $donation->campaign_id) {
                $oldCampaign = Campaign::find($oldCampaignId);
                if ($oldCampaign) {
                    $oldCampaign->updateTotalDonations();
                }
            }

            // Update current campaign if amount changed or campaign changed
            if ($donation->campaign_id && ($oldAmount !== $donation->amount || $oldCampaignId !== $donation->campaign_id)) {
                $donation->campaign->updateTotalDonations();
            }
        }

        return redirect()
            ->route('admin.donations.show', $donation)
            ->with('success', 'Donation updated successfully.');
    }

    public function destroy(Donation $donation)
{
    // Store campaign info before deletion
    $campaign = null;
    if ($donation->type === 'monetary' && $donation->campaign_id) {
        $campaign = $donation->campaign;
    }

    $donation->delete();

    // Update campaign total donations if this was a monetary donation
    if ($campaign) {
        $campaign->updateTotalDonations();
    }

    // If the request expects JSON (AJAX), return a JSON response
    if (request()->expectsJson()) {
        return response()->json(['success' => true]);
    }

    // Otherwise, redirect back (for normal form submissions)
    return redirect()->back()->with('success', 'Donation deleted!');
}

    public function updateStatus(Request $request, Donation $donation)
    {
        Log::info('updateStatus method called.', [
            'request_method' => $request->method(),
            'donation_id' => $donation->id,
            'status_payload' => $request->input('status'),
        ]);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled,rejected,rescheduled',
        ]);

        $oldStatus = $donation->status;
        $donation->update($validated);

        // Update campaign total donations if this is a monetary donation and status changed
        if ($donation->type === 'monetary' && $oldStatus !== $donation->status) {
            // Update regular campaign if exists
            if ($donation->campaign_id) {
                $campaign = $donation->campaign;
                if ($campaign) {
                    $campaign->updateTotalDonations();
                }
            }

            // Update urgent campaign if exists
            if ($donation->urgent_campaign_id) {
                $urgentCampaign = $donation->urgentCampaign;
                if ($urgentCampaign) {
                    $urgentCampaign->updateTotalDonations();
                }
            }
        }

        if ($donation->type === 'monetary' && $donation->status === 'approved') {
            Mail::to($donation->donor_email)->send(new MonetaryDonationReceived($donation));
        } elseif ($donation->type === 'non-monetary') {
            switch ($donation->status) {
                case 'approved':
                    // Send drop-off confirmation when donation is approved
                    Mail::to($donation->donor_email)->send(new NonMonetaryDropoffConfirmed($donation));
                    break;
                case 'completed':
                    // Send received confirmation when donation is physically received
                    Mail::to($donation->donor_email)->send(new NonMonetaryReceivedConfirmation($donation));
                    break;
                case 'rejected':
                    Mail::to($donation->donor_email)->send(new NonMonetaryRejected($donation));
                    break;
                case 'rescheduled':
                    Mail::to($donation->donor_email)->send(new NonMonetaryRescheduled($donation));
                    break;
            }
        }

        return back()->with('success', 'Donation status updated successfully.');
    }

    public function rejectDonation(Request $request, Donation $donation)
    {
        // Validate the rejection reason
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000',
        ], [
            'rejection_reason.required' => 'A rejection reason is required.',
            'rejection_reason.min' => 'The rejection reason must be at least 10 characters.',
            'rejection_reason.max' => 'The rejection reason cannot exceed 1000 characters.',
        ]);

        $oldStatus = $donation->status;
        $donation->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason']
        ]);

        // Update campaign total donations if this is a monetary donation and status changed
        if ($donation->type === 'monetary' && $donation->campaign_id && $oldStatus !== 'rejected') {
            $campaign = $donation->campaign;
            if ($campaign) {
                $campaign->updateTotalDonations();
            }
        }

        // Send the new custom rejection email
        Mail::to($donation->donor_email)->send(new DonationRejectedWithReason($donation));

        return back()->with('success', 'Donation has been rejected and the donor has been notified with the reason.');
    }

    public function rescheduleDonation(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'expected_date' => 'required|date|after:today',
        ]);

        $oldStatus = $donation->status;
        $donation->update([
            'status' => 'rescheduled',
            'expected_date' => $validated['expected_date']
        ]);

        // Update campaign total donations if this is a monetary donation and status changed
        if ($donation->type === 'monetary' && $donation->campaign_id && $oldStatus !== 'rescheduled') {
            $campaign = $donation->campaign;
            if ($campaign) {
                $campaign->updateTotalDonations();
            }
        }

        Mail::to($donation->donor_email)->send(new NonMonetaryRescheduled($donation));
        return back()->with('success', 'Donation has been rescheduled and the donor has been notified.');
    }

    /**
     * Show the form for editing donation amount only
     */
    public function editAmount(Donation $donation)
    {
        // Only allow editing monetary donations
        if ($donation->type !== 'monetary') {
            return redirect()->route('admin.donations.show', $donation)
                ->with('error', 'Only monetary donations can have their amounts edited.');
        }

        return view('admin.donation.edit-amount', compact('donation'));
    }

    /**
     * Update the donation amount with audit trail
     */
    public function updateAmount(Request $request, Donation $donation)
    {
        // Only allow editing monetary donations
        if ($donation->type !== 'monetary') {
            return redirect()->route('admin.donations.show', $donation)
                ->with('error', 'Only monetary donations can have their amounts edited.');
        }

        $validated = $request->validate([
            'confirmed_amount' => 'required|numeric|min:0',
            'admin_notes' => 'nullable|string|max:1000',
        ], [
            'confirmed_amount.required' => 'The confirmed amount is required.',
            'confirmed_amount.numeric' => 'The confirmed amount must be a valid number.',
            'confirmed_amount.min' => 'The confirmed amount cannot be negative.',
            'admin_notes.max' => 'Admin notes cannot exceed 1000 characters.',
        ]);

        // Store original amount if this is the first edit
        if (!$donation->hasBeenEdited()) {
            $donation->original_amount = $donation->amount;
        }

        // Store old values for campaign total updates
        $oldAmount = $donation->confirmed_amount ?? $donation->amount;

        // Update the donation with audit trail
        $donation->update([
            'confirmed_amount' => $validated['confirmed_amount'],
            'admin_notes' => $validated['admin_notes'],
            'edited_by' => auth()->id(),
            'edited_at' => now(),
        ]);

        // Update campaign totals if this is a completed monetary donation
        if ($donation->status === 'completed' && $donation->campaign_id) {
            $donation->campaign->updateTotalDonations();
        }

        // Update urgent campaign totals if applicable
        if ($donation->status === 'completed' && $donation->urgent_campaign_id) {
            $donation->urgentCampaign->updateTotalDonations();
        }

        return redirect()
            ->route('admin.donations.show', $donation)
            ->with('success', 'Donation amount has been updated successfully. Original amount preserved for audit.');
    }

    public function dropoffs()
    {
        // Show approved non-monetary donations awaiting physical drop-off
        // Sort by expected_date ascending (soonest drop-offs first), then by created_at for items without expected_date
        $pendingDropoffs = Donation::where('type', 'non-monetary')
            ->where('status', 'approved')
            ->orderByRaw('expected_date IS NULL, expected_date ASC, created_at ASC')
            ->get();

        // Show donations that have been physically received (completed)
        // Sort by updated_at descending (most recently received first)
        $completedDropoffs = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->latest('updated_at')
            ->get();

        // Get total non-monetary donors count (only completed donations - items actually received)
        $totalNonMonetaryDonors = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->distinct('donor_name')
            ->count('donor_name');

        return view('admin.donation.dropoffs', compact('pendingDropoffs', 'completedDropoffs', 'totalNonMonetaryDonors'));
    }

    public function serveProofImage($filename)
    {
        // Ensure the proof_path exists for the given filename and is not null
        $donation = Donation::where('proof_path', 'like', '%' . $filename)->first();

        if (!empty($donation->proof_path) && Storage::disk('public')->exists($donation->proof_path)) {
            return Storage::disk('public')->response($donation->proof_path);
        } else {
            abort(404);
        }
    }

    public function allDonations(Request $request)
    {
        $query = Donation::with(['donor', 'campaign']);

        if ($request->has('search_donations')) {
            $search = $request->input('search_donations');
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', '%' . $search . '%')
                    ->orWhere('donor_email', 'like', '%' . $search . '%')
                    ->orWhere('item_name', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('campaign', function($q_campaign) use ($search) {
                        $q_campaign->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $donations = $query->latest()->paginate(10);

        return view('admin.donations.all', compact('donations'));
    }

    public function allDonors(Request $request)
    {
        $query = Donation::with(['campaign', 'urgentCampaign']);

        // Apply search filter
        if ($request->has('search_donations')) {
            $search = $request->input('search_donations');
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', '%' . $search . '%')
                    ->orWhere('donor_email', 'like', '%' . $search . '%')
                    ->orWhere('item_name', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        // Apply donation type filter
        if ($request->has('filter') && $request->filter !== 'all') {
            switch ($request->filter) {
                case 'monetary':
                    $query->where('type', 'monetary');
                    break;
                case 'non-monetary':
                    $query->where('type', 'non-monetary');
                    break;
                case 'campaigns':
                    $query->where(function($q) {
                        $q->whereNotNull('campaign_id')
                          ->orWhereNotNull('urgent_campaign_id');
                    });
                    break;
                case 'urgent':
                    $query->whereNotNull('urgent_campaign_id');
                    break;
            }
        }

        $donations = $query->latest()->paginate(10);

        // Get completed donations for the new section (only approved donations)
        $completedDonationsQuery = Donation::with(['campaign', 'urgentCampaign'])
            ->where('status', 'approved');

        // Apply same search filter to completed donations
        if ($request->has('search_donations')) {
            $search = $request->input('search_donations');
            $completedDonationsQuery->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', '%' . $search . '%')
                    ->orWhere('donor_email', 'like', '%' . $search . '%')
                    ->orWhere('item_name', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        $completedDonations = $completedDonationsQuery->latest()->paginate(10, ['*'], 'completed_page');

        // Get total donors count by unique donor names (only actual received donations)
        // For monetary: approved and completed are both valid (payment received)
        // For non-monetary: only completed is valid (items physically received)
        $totalDonors = Donation::where(function($query) {
            $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
        })->orWhere(function($query) {
            $query->where('type', 'non-monetary')->where('status', 'completed');
        })->distinct('donor_name')->count('donor_name');

        // Get breakdown counts for the Total Donors card
        $monetaryDonors = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->distinct('donor_name')
            ->count('donor_name');

        $nonMonetaryDonors = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->distinct('donor_name')
            ->count('donor_name');

        $campaignDonors = Donation::where(function($query) {
                $query->whereNotNull('campaign_id')->orWhereNotNull('urgent_campaign_id');
            })
            ->where(function($query) {
                $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
            })
            ->orWhere(function($query) {
                $query->where('type', 'non-monetary')->where('status', 'completed')
                      ->where(function($subQuery) {
                          $subQuery->whereNotNull('campaign_id')->orWhereNotNull('urgent_campaign_id');
                      });
            })
            ->distinct('donor_name')
            ->count('donor_name');

        return view('admin.donation.all-donors', compact('donations', 'completedDonations', 'totalDonors', 'monetaryDonors', 'nonMonetaryDonors', 'campaignDonors'));
    }

    public function pending(Request $request)
    {
        $query = Donation::with(['campaign', 'urgentCampaign'])->where('status', 'pending')->latest();

        if ($request->has('search_pending_donations')) {
            $search = $request->input('search_pending_donations');
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', '%' . $search . '%')
                    ->orWhere('donor_email', 'like', '%' . $search . '%')
                    ->orWhere('item_name', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        $pendingDonations = $query->paginate(10);

        return view('admin.donation.pending', compact('pendingDonations'));
    }

    public function reports()
    {
        // This method is now handled by ReportController
        return redirect()->route('admin.reports.index');
    }
} 