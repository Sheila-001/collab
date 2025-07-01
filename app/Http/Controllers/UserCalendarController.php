<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarCampaign;
use App\Models\CalendarCategory;
use App\Models\Campaign;

class UserCalendarController extends Controller
{
    public function index(Request $request)
    {
        // Get the year from request, default to current year
        $currentYear = $request->get('year', date('Y'));

        // Validate year (between 2020 and 2030)
        if (!is_numeric($currentYear) || $currentYear < 2020 || $currentYear > 2030) {
            $currentYear = date('Y');
        }

        $statusColors = [
            'scheduled' => '#34D399', // Green
            'pending' => '#FBBF24',   // Yellow
            'done' => '#6366F1',      // Indigo
            'cancelled' => '#EF4444', // Red
        ];

        // Get events for the selected year, but only current and future events
        $startOfYear = $currentYear . '-01-01';
        $endOfYear = $currentYear . '-12-31';

        $calendarCampaigns = CalendarCampaign::with('category')
            ->where(function($query) use ($startOfYear, $endOfYear) {
                $query->whereBetween('start_date', [$startOfYear, $endOfYear])
                      ->orWhereBetween('end_date', [$startOfYear, $endOfYear])
                      ->orWhere(function($q) use ($startOfYear, $endOfYear) {
                          $q->where('start_date', '<=', $startOfYear)
                            ->where('end_date', '>=', $endOfYear);
                      });
            })
            ->where('end_date', '>=', now()->startOfDay()) // Hide expired events from users
            ->orderBy('start_date', 'asc')
            ->get()
            ->map(function ($campaign) use ($statusColors) {
                return [
                    'id' => $campaign->id,
                    'title' => $campaign->title,
                    'start' => $campaign->start_date->format('Y-m-d'),
                    'end' => $campaign->end_date->format('Y-m-d'),
                    'start_datetime' => $campaign->start_date->format('Y-m-d H:i:s'),
                    'end_datetime' => $campaign->end_date->format('Y-m-d H:i:s'),
                    'start_time' => $campaign->start_date->format('H:i'),
                    'end_time' => $campaign->end_date->format('H:i'),
                    'category' => $campaign->category->name,
                    'categoryColor' => $campaign->category->color ?? '#D4D4D4', // Use category color
                    'status' => $campaign->status,
                    'statusColor' => $statusColors[$campaign->status] ?? '#D4D4D4', // Use status color
                    'className' => 'bg-[' . ($campaign->category->color ?? '#D4D4D4') . ']',
                    'pledged' => $campaign->pledged_amount ?? 0, // Assuming this field exists
                    'notes' => $campaign->notes, // Add notes field
                    'address' => $campaign->address, // Add address field
                ];
            });

        $categories = CalendarCategory::orderBy('name')->get();

        $campaigns = Campaign::acceptingDonations()->get();

        return view('donation.usercalendar', compact('calendarCampaigns', 'categories', 'campaigns', 'currentYear'));
    }

    /**
     * Get events data for AJAX requests (used by calendar widgets)
     */
    public function getEvents(Request $request)
    {
        // Get the year from request, default to current year
        $currentYear = $request->get('year', date('Y'));

        // Validate year (between 2020 and 2030)
        if (!is_numeric($currentYear) || $currentYear < 2020 || $currentYear > 2030) {
            $currentYear = date('Y');
        }

        $statusColors = [
            'scheduled' => '#34D399', // Green
            'pending' => '#FBBF24',   // Yellow
            'done' => '#6366F1',      // Indigo
            'cancelled' => '#EF4444', // Red
        ];

        // Get events for the selected year, but only current and future events
        $startOfYear = $currentYear . '-01-01';
        $endOfYear = $currentYear . '-12-31';

        $events = CalendarCampaign::with('category')
            ->where(function($query) use ($startOfYear, $endOfYear) {
                $query->whereBetween('start_date', [$startOfYear, $endOfYear])
                      ->orWhereBetween('end_date', [$startOfYear, $endOfYear])
                      ->orWhere(function($q) use ($startOfYear, $endOfYear) {
                          $q->where('start_date', '<=', $startOfYear)
                            ->where('end_date', '>=', $endOfYear);
                      });
            })
            ->where('end_date', '>=', now()->startOfDay()) // Hide expired events from users
            ->orderBy('start_date', 'asc')
            ->get()
            ->map(function ($campaign) use ($statusColors) {
                return [
                    'id' => $campaign->id,
                    'title' => $campaign->title,
                    'start' => $campaign->start_date->format('Y-m-d'),
                    'end' => $campaign->end_date->format('Y-m-d'),
                    'start_datetime' => $campaign->start_date->format('Y-m-d H:i:s'),
                    'end_datetime' => $campaign->end_date->format('Y-m-d H:i:s'),
                    'start_time' => $campaign->start_date->format('H:i'),
                    'end_time' => $campaign->end_date->format('H:i'),
                    'category' => $campaign->category->name,
                    'categoryColor' => $campaign->category->color ?? '#D4D4D4',
                    'status' => $campaign->status,
                    'statusColor' => $statusColors[$campaign->status] ?? '#D4D4D4',
                    'className' => 'bg-[' . ($campaign->category->color ?? '#D4D4D4') . ']',
                    'notes' => $campaign->notes,
                    'address' => $campaign->address,
                ];
            });

        return response()->json($events);
    }
}