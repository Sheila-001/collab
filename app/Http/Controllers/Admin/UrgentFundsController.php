<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;

class UrgentFundsController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::query();

        // Check for filter parameter
        if ($request->has('filter') && $request->get('filter') === 'urgent') {
            $query->where('is_urgent', true);
        }

        $allCampaigns = $query->get();
        // We still need $urgentCampaigns for the separate Urgent Campaigns section
        $urgentCampaigns = Campaign::where('is_urgent', true)->get();

        return view('admin.donation.urgent-fund.index', compact('allCampaigns', 'urgentCampaigns'));
    }

    public function create()
    {
        return view('admin.donation.urgent-fund.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'is_urgent' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['funds_raised'] = 0;
        $validated['is_urgent'] = $request->has('is_urgent');

        Campaign::create($validated);

        return redirect()->route('admin.urgent-funds.index')
            ->with('success', 'Campaign created successfully.');
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.donation.urgent-fund.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        dd($request->all()); // Temporarily dump request data

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'funds_raised' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_urgent'] = $request->has('is_urgent');
        $validated['funds_raised'] = $request->input('funds_raised');

        $campaign->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Campaign updated successfully!',
                'campaign' => $campaign
            ]);
        }

        return redirect()->route('admin.urgent-funds.index')
            ->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }
        
        $campaign->delete();

        return redirect()->route('admin.urgent-funds.index')
            ->with('success', 'Campaign deleted successfully.');
    }
} 
