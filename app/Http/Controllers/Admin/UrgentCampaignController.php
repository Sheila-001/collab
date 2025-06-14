<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UrgentCampaign;

class UrgentCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urgentCampaigns = UrgentCampaign::all();
        return view('admin.urgent_campaigns.index', compact('urgentCampaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.urgent_campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'ends_at' => 'nullable|date',
        ]);

        UrgentCampaign::create($request->all());

        return redirect()->route('admin.urgent-campaigns.index')->with('success', 'Urgent campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $urgentCampaign = UrgentCampaign::findOrFail($id);
        return view('admin.urgent_campaigns.show', compact('urgentCampaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $urgentCampaign = UrgentCampaign::findOrFail($id);
        return view('admin.urgent_campaigns.edit', compact('urgentCampaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $urgentCampaign = UrgentCampaign::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'ends_at' => 'nullable|date',
        ]);

        $urgentCampaign->update($request->all());

        return redirect()->route('admin.urgent-campaigns.index')->with('success', 'Urgent campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $urgentCampaign = UrgentCampaign::findOrFail($id);
        $urgentCampaign->delete();

        return redirect()->route('admin.urgent-campaigns.index')->with('success', 'Urgent campaign deleted successfully.');
    }
}
