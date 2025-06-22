<?php

namespace App\Http\Controllers;

use App\Models\Event;
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

        return view('welcome', compact('events'));
    }
}