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

        // Get total monetary donations
        $monetaryTotal = Donation::where('type', 'monetary')
            ->where('status', 'completed')
            ->sum('amount');

        // Calculate monetary change
        $lastMonthMonetary = Donation::where('type', 'monetary')
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');
        
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

        // Get campaign total and change (using existing logic, but now linked to $totalCampaigns)
        $campaignTotal = Donation::whereHas('campaign', function($query) {
                $query->where('status', 'active');
            })
            ->where('status', 'completed')
            ->sum('amount');
        
        $lastMonthCampaign = Donation::whereHas('campaign', function($query) use ($lastMonth) {
                $query->where('status', 'active');
            })
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');
        
        $campaignChange = $lastMonthCampaign > 0 
            ? (($campaignTotal - $lastMonthCampaign) / $lastMonthCampaign) * 100 
            : 0;

        // Get donor count and change
        $donorCount = Donor::count();
        
        $lastMonthDonors = Donor::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        $donorChange = $lastMonthDonors > 0 
            ? (($donorCount - $lastMonthDonors) / $lastMonthDonors) * 100 
            : 0;

        // Query for recent donations (no filter/search on index page)
        $donations = Donation::with(['campaign'])->latest()->limit(5)->get();

        // Get pending drop-offs for the new section
        $pendingDonationsQuery = Donation::where('status', 'pending')->latest();

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
            'pendingDonations'
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
        $campaigns = Campaign::where('status', 'active')->get();
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
            'quantity' => 'required_if:type,non-monetary|integer|min:1',
            'expected_date' => 'required_if:type,non-monetary|date|after:today',
            'notes' => 'nullable|string',
            'category' => 'required_if:type,non-monetary|nullable|string|max:255',
            'condition' => 'required_if:type,non-monetary|nullable|string|max:255',
        ]);

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

        return redirect()
            ->route('admin.donations.show', $donation)
            ->with('success', 'Donation updated successfully.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Donation deleted successfully.');
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        Log::info('updateStatus method called.', [
            'request_method' => $request->method(),
            'donation_id' => $donation->id,
            'status_payload' => $request->input('status'),
        ]);

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $donation->update($validated);

        if ($donation->type === 'monetary' && $donation->status === 'completed') {
            Mail::to($donation->donor_email)->send(new MonetaryDonationReceived($donation));
        } elseif ($donation->type === 'non-monetary' && $donation->status === 'completed') {
            Mail::to($donation->donor_email)->send(new NonMonetaryDropoffConfirmed($donation));
        }

        return back()->with('success', 'Donation status updated successfully.');
    }

    public function dropoffs()
    {
        $pendingDropoffs = Donation::where('type', 'non-monetary')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $completedDropoffs = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->latest()
            ->get();
        
        return view('admin.donation.dropoffs', compact('pendingDropoffs', 'completedDropoffs'));
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
        $query = Donation::query();

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
                    $query->whereNotNull('campaign_id');
                    break;
            }
        }

        $donations = $query->latest()->paginate(10);

        return view('admin.donation.all-donors', compact('donations'));
    }

    public function pending(Request $request)
    {
        $query = Donation::where('status', 'pending')->latest();

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