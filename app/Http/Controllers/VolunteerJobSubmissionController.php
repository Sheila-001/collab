<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\Event;
use App\Models\JobListing;
use Illuminate\Support\Facades\Validator;

class VolunteerJobSubmissionController extends Controller
{
    public function index()
    {
        // Logic to retrieve volunteers data
        $volunteers = Volunteer::all();
        return view('volunteers.index', compact('volunteers'));
    }

    /**
     * Store a newly created volunteer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:volunteers',
            'phone' => 'required|string|max:20',
            'skills' => 'nullable|array',
            'status' => 'required|in:Active,Pending,Inactive',
            'notes' => 'nullable|string',
            'start_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        try {
            // Create the volunteer
            $volunteer = Volunteer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'skills' => $request->skills ? json_encode($request->skills) : null,
                'status' => $request->status,
                'notes' => $request->notes,
                'start_date' => $request->start_date,
            ]);

            return response()->json([
                'message' => 'Volunteer created successfully',
                'id' => $volunteer->id,
                'volunteer' => $volunteer
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create volunteer', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the volunteer's status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Active,Pending,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        try {
            // Find the volunteer
            $volunteer = Volunteer::findOrFail($id);
            
            // Update the status
            $volunteer->status = $request->status;
            $volunteer->save();

            return response()->json([
                'message' => 'Volunteer status updated successfully',
                'volunteer' => $volunteer
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update volunteer status', 'error' => $e->getMessage()], 500);
        }
    }

    public function viewEvents()
    {
        // Logic for viewing events
        return view('volunteers.events');
    }

    public function viewCalendar()
    {
        // Logic for viewing calendar
        return view('volunteers.calendar');
    }

    public function addJobOffer(Request $request)
    {
        // Logic for adding job offers
        // Implement validation and job offer creation
        return back()->with('success', 'Job offer added successfully');
    }

    public function dashboard()
    {
        try {
            // Load only admin-posted and active events
            $events = Event::where('status', 'active')
                          ->where('is_admin_posted', true)
                          ->where('end_date', '>', now())
                          ->get();
            
            // Load only admin-posted and approved jobs
            $jobs = JobListing::where('status', 'approved')
                             ->where('is_admin_posted', true)
                             ->where(function($query) {
                                 $query->whereNull('expires_at')
                                       ->orWhere('expires_at', '>', now());
                             })
                             ->get();
            
            return view('volunteers.volunteerdashboard', compact('events', 'jobs'));
        } catch (\Exception $e) {
            \Log::error('Volunteer Dashboard Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the dashboard.');
        }
    }
} 