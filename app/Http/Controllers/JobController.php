<?php
namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobListing::all();
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'role' => 'required|string|max:255',
                'company' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'apply' => 'required|string|max:255',
                'location' => 'required|string|max:255',
            ]);

            // Create the job listing
            $job = JobListing::create([
                'role' => $validated['role'],
                'company' => $validated['company'],
                'contact' => $validated['contact'],
                'apply' => $validated['apply'],
                'location' => $validated['location'],
                'status' => 'pending', // Set initial status as pending for admin approval
                'is_admin' => auth()->user()->is_admin
            ]);

            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Job submitted successfully! Waiting for admin approval.',
                    'job' => $job
                ], 201);
            }

            return redirect()->route('jobs.index')
                ->with('success', 'Job listing created successfully.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Error submitting job.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error creating job listing.');
        }
    }

    public function show(JobListing $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(JobListing $job)
    {
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, JobListing $job)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'apply' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.index')
            ->with('success', 'Job listing updated successfully.');
    }

    public function destroy(JobListing $job)
    {
        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Job listing deleted successfully.');
    }

    public function approve(JobListing $job)
    {
        $job->update(['status' => 'approved']);

        return redirect()->route('jobs.index')
            ->with('success', 'Job listing approved successfully.');
    }

    public function reject(JobListing $job)
    {
        $job->update(['status' => 'rejected']);

        return redirect()->route('jobs.index')
            ->with('success', 'Job listing rejected successfully.');
    }
}