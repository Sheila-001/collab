<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarCampaign;
use App\Models\CalendarCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CalendarCampaignController extends Controller
{
    public function create()
    {
        $statuses = CalendarCampaign::STATUSES;
        $categories = CalendarCategory::orderBy('name')->pluck('name', 'id');
        
        return view('admin.calendar.calendar_campaign', compact('statuses', 'categories'));
    }

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
     * Display the calendar management page with filtering options
     */
    public function manage(Request $request)
    {
        $filter = $request->get('filter', 'active'); // Default to active

        $query = CalendarCampaign::with('category');

        // Apply filters
        if ($filter === 'active') {
            $campaigns = $query->currentAndFuture()->orderBy('start_date', 'asc')->get();
        } elseif ($filter === 'inactive') {
            $campaigns = $query->past()->orderBy('start_date', 'desc')->get();
        } else {
            $campaigns = $query->orderBy('start_date', 'desc')->get();
        }

        $categories = CalendarCategory::orderBy('name')->get();

        return view('admin.calendar.manage', compact('campaigns', 'categories', 'filter'));
    }

    /**
     * Show the specified calendar campaign
     */
    public function show(CalendarCampaign $campaign)
    {
        $campaign->load('category');
        return view('admin.calendar.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified calendar campaign
     */
    public function edit(CalendarCampaign $campaign)
    {
        $statuses = CalendarCampaign::STATUSES;
        $categories = CalendarCategory::orderBy('name')->pluck('name', 'id');

        return view('admin.calendar.edit', compact('campaign', 'statuses', 'categories'));
    }

    /**
     * Update the specified calendar campaign
     */
    public function update(Request $request, CalendarCampaign $campaign)
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

        // Update the campaign with combined datetime
        $campaign->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'start_date' => $startDateTime,
            'end_date' => $endDateTime,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'address' => $validated['address'],
        ]);

        return redirect()
            ->route('admin.calendar-campaigns.manage')
            ->with('success', 'Campaign has been updated successfully.');
    }

    /**
     * Remove the specified calendar campaign
     */
    public function destroy(CalendarCampaign $campaign)
    {
        try {
            $campaign->delete();

            // Check if request expects JSON (for AJAX requests)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Calendar event has been deleted successfully.'
                ]);
            }

            return redirect()
                ->route('admin.calendar-campaigns.manage')
                ->with('success', 'Calendar event has been deleted successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete calendar event. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('admin.calendar-campaigns.manage')
                ->with('error', 'Failed to delete calendar event. Please try again.');
        }
    }
}