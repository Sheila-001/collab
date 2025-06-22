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
     * Admin calendar shows ALL events (including past events) for management purposes.
     */
    public function index()
    {
        // Admin calendar shows all events (past, current, and future) for management
        $campaigns = CalendarCampaign::with('category')->get()->map(function ($campaign) {
            return [
                'id' => $campaign->id,
                'title' => $campaign->title,
                'start' => $campaign->start_date->format('Y-m-d\TH:i:s'),
                'end' => $campaign->end_date->format('Y-m-d\TH:i:s'),
                'category' => $campaign->category->name,
                'status' => $campaign->status,
                'notes' => $campaign->notes,
                'address' => $campaign->address,
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
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'address' => 'nullable|string|max:500',
        ], [
            'title.required' => 'The campaign title is required.',
            'title.max' => 'The campaign title cannot exceed 255 characters.',
            'category_id.required' => 'The campaign category is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'start_time.date_format' => 'The start time must be in HH:MM format.',
            'end_time.date_format' => 'The end time must be in HH:MM format.',
            'status.required' => 'The campaign status is required.',
            'address.max' => 'The address cannot exceed 500 characters.',
        ]);

        // Combine date and time for start_date
        $startDateTime = $validated['start_date'];
        if (!empty($validated['start_time'])) {
            $startDateTime .= ' ' . $validated['start_time'];
        } else {
            $startDateTime .= ' 00:00:00';
        }

        // Combine date and time for end_date
        $endDateTime = $validated['end_date'];
        if (!empty($validated['end_time'])) {
            $endDateTime .= ' ' . $validated['end_time'];
        } else {
            $endDateTime .= ' 23:59:59';
        }

        // Create the campaign with combined datetime
        CalendarCampaign::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'start_date' => $startDateTime,
            'end_date' => $endDateTime,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'address' => $validated['address'],
        ]);

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
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
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
