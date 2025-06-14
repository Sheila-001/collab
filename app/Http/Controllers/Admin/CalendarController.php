<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarCampaign;
use App\Models\CalendarCategory;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display the calendar view with campaign events.
     */
    public function index()
    {
        $campaigns = CalendarCampaign::with('category')->get()->map(function ($campaign) {
            return [
                'id' => $campaign->id,
                'title' => $campaign->title,
                'start' => $campaign->start_date->format('Y-m-d'),
                'end' => $campaign->end_date->format('Y-m-d'),
                'category' => $campaign->category->name,
                'status' => $campaign->status,
                'className' => 'bg-[' . $campaign->category->color . ']',
            ];
        });

        $categories = CalendarCategory::orderBy('name')->get();
        
        return view('admin.calendar.index', compact('campaigns', 'categories'));
    }

    private function getCategoryColor($category)
    {
        return $category->color ?? '#D4D4D4';
    }

    /**
     * Store a new campaign event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:calendar_categories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $campaign = CalendarCampaign::create($validated);

        return redirect()
            ->route('admin.calendar.index')
            ->with('success', 'Campaign has been scheduled successfully.');
    }

    /**
     * Update a campaign event's dates.
     */
    public function update(Request $request, CalendarCampaign $campaign)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $campaign->update($validated);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a campaign event.
     */
    public function destroy(CalendarCampaign $campaign)
    {
        $campaign->delete();
        return response()->json(['success' => true]);
    }
} 
