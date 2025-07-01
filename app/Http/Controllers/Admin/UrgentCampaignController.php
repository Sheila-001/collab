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
            'ends_at' => 'nullable|date|after:now',
        ], [
            'title.required' => 'The campaign title is required.',
            'title.max' => 'The campaign title cannot exceed 255 characters.',
            'description.required' => 'The campaign description is required.',
            'goal_amount.required' => 'The goal amount is required.',
            'goal_amount.numeric' => 'The goal amount must be a number.',
            'goal_amount.min' => 'The goal amount must be greater than or equal to 0.',
            'ends_at.date' => 'The end date must be a valid date.',
            'ends_at.after' => 'The end date must be in the future.',
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
            'ends_at' => 'nullable|date|after:now',
        ], [
            'title.required' => 'The campaign title is required.',
            'title.max' => 'The campaign title cannot exceed 255 characters.',
            'description.required' => 'The campaign description is required.',
            'goal_amount.required' => 'The goal amount is required.',
            'goal_amount.numeric' => 'The goal amount must be a number.',
            'goal_amount.min' => 'The goal amount must be greater than or equal to 0.',
            'ends_at.date' => 'The end date must be a valid date.',
            'ends_at.after' => 'The end date must be in the future.',
        ]);

        $urgentCampaign->update($request->all());

        return redirect()->route('admin.urgent-campaigns.index')->with('success', 'Urgent campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $urgentCampaign = UrgentCampaign::findOrFail($id);
            $urgentCampaign->delete();

            // Handle AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Urgent campaign deleted successfully.'
                ]);
            }

            return redirect()->route('admin.urgent-campaigns.index')->with('success', 'Urgent campaign deleted successfully.');
        } catch (\Exception $e) {
            // Handle AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete urgent campaign: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.urgent-campaigns.index')->with('error', 'Failed to delete urgent campaign.');
        }
    }
}
