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
                // Only count approved donations
                $campaign->funds_raised = $campaign->donations()
                    ->where('type', 'monetary')
                    ->where('status', 'approved')
                    ->sum('amount');
                $campaign->type = $campaign->type ?? 'Regular';

                // Add computed status for display
                $campaign->display_status = $campaign->computed_status;

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

        // Get active campaigns count (only currently running campaigns)
        $activeCampaigns = Campaign::where('status', 'active')
            ->where('start_date', '<=', Carbon::now())  // ✅ Must have started
            ->where('end_date', '>', Carbon::now())     // ✅ Must not have ended
            ->where('is_archived', false)
            ->count();

        // Get total donations amount
        $totalDonations = Donation::where('status', 'approved')
            ->sum('amount');

        // Get total unique donors count
        $totalDonors = Donation::where('status', 'approved')
            ->distinct('donor_email')
            ->count('donor_email');

        // Get scheduled campaigns count (campaigns that haven't started yet)
        $scheduledCampaigns = Campaign::where('status', 'active')
            ->where('start_date', '>', Carbon::now())
            ->where('is_archived', false)
            ->count();

        // Get paused campaigns count
        $pausedCampaigns = Campaign::where('status', 'paused')
            ->where('is_archived', false)
            ->count();

        // Get total pending campaigns (scheduled + paused) for backward compatibility
        $pendingCampaigns = $scheduledCampaigns + $pausedCampaigns;

        // Get currently running campaigns with their current amounts (only completed donations)
        $campaigns = Campaign::where('status', 'active')
            ->where('start_date', '<=', Carbon::now())  // ✅ Must have started
            ->where('end_date', '>', Carbon::now())     // ✅ Must not have ended
            ->where('is_archived', false)
            ->latest()
            ->get()
            ->map(function ($campaign) {
                // Use total_donations which only counts approved donations
                $campaign->current_amount = $campaign->total_donations ?? 0;
                return $campaign;
            });

        return view('admin.campaigns.dashboard', compact(
            'activeCampaigns',
            'totalDonations',
            'totalDonors',
            'pendingCampaigns',
            'scheduledCampaigns',
            'pausedCampaigns',
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

        // Set default status to 'active' since it's not in the form anymore
        $validated['status'] = 'active';

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
        // Only count completed donations
        $campaign->funds_raised = $campaign->donations()
            ->where('type', 'monetary')
            ->where('status', 'completed')
            ->sum('amount');

        return view('admin.campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified campaign.
     */
    public function edit(Campaign $campaign)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.campaigns.edit', compact('campaign', 'categories'));
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
        try {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }

            $campaign->delete();

            // Handle AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Campaign deleted successfully.'
                ]);
            }

            return redirect()->route('admin.campaigns.index')
                ->with('success', 'Campaign deleted successfully.');
        } catch (\Exception $e) {
            // Handle AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete campaign: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.campaigns.index')
                ->with('error', 'Failed to delete campaign: ' . $e->getMessage());
        }
    }
} 