<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\UrgentCampaign;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get upcoming events for the welcome page
        $events = Event::where('start_date', '>', Carbon::now())
            ->orderBy('start_date', 'asc')
            ->take(6)
            ->get();

        // Get active urgent campaigns
        $urgentCampaigns = UrgentCampaign::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('ends_at')
                      ->orWhere('ends_at', '>', Carbon::now());
            })
            ->get();

        return view('welcome', compact('events', 'urgentCampaigns'));
    }
}