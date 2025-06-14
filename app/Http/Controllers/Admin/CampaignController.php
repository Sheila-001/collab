<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the campaigns.
     */
    public function index()
    {
        $campaigns = Campaign::with(['donations', 'category'])
            ->latest()
            ->paginate(10)
            ->through(function ($campaign) {
                $campaign->funds_raised = $campaign->donations->sum('amount');
                $campaign->type = $campaign->type ?? 'Regular';
                return $campaign;
            });

        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * Display the campaign management dashboard.
     */
    public function dashboard()
    {
        // Log the admin status of the authenticated user
        if (Auth::check()) {
            \Illuminate\Support\Facades\Log::info('Admin Dashboard Access Attempt', [
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'is_admin' => Auth::user()->is_admin,
            ]);
        } else {
            \Illuminate\Support\Facades\Log::info('Admin Dashboard Access Attempt - No User Authenticated');
        }

        // Get active campaigns count
        $activeCampaigns = Campaign::where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->count();

        // Get total donations amount
        $totalDonations = Donation::where('status', 'completed')
            ->sum('amount');

        // Get total unique donors count
        $totalDonors = Donation::where('status', 'completed')
            ->distinct('donor_email')
            ->count('donor_email');

        // Get pending campaigns count
        $pendingCampaigns = Campaign::where('status', 'paused')
            ->orWhere(function($query) {
                $query->where('status', 'active')
                      ->where('start_date', '>', Carbon::now());
            })
            ->count();

        // Get active campaigns with their current amounts
        $campaigns = Campaign::where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->withSum('donations as current_amount', 'amount')
            ->latest()
            ->get()
            ->map(function ($campaign) {
                // Ensure current_amount is not null
                $campaign->current_amount = $campaign->current_amount ?? 0;
                return $campaign;
            });

        return view('admin.campaigns.dashboard', compact(
            'activeCampaigns',
            'totalDonations',
            'totalDonors',
            'pendingCampaigns',
            'campaigns'
        ));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.campaigns.create', compact('categories'));
    }

    /**
     * Store a newly created campaign in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        Campaign::create($validated);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified campaign.
     */
    public function show(Campaign $campaign)
    {
        $campaign->load('donations');
        $campaign->funds_raised = $campaign->donations->sum('amount');

        return view('admin.campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified campaign.
     */
    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified campaign in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $campaign->update($validated);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign updated successfully.');
    }

    /**
     * Remove the specified campaign from storage.
     */
    public function destroy(Campaign $campaign)
    {
        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }
        
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }
} 