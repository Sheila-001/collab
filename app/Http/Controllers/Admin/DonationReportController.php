<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DonationReportController extends Controller
{
    public function index(Request $request)
    {
        // Calculate summary statistics - use effective amount
        $monetaryDonationsTotal = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->get()
            ->sum('effective_amount');
        $nonMonetaryDonationsCount = Donation::where('type', 'non-monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->count();
        $campaignsCount = Campaign::count();
        // Count unique donors based on email - only from approved/completed donations
        $donorsCount = Donation::whereNotNull('donor_email')
            ->where(function($query) {
                $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
            })
            ->orWhere(function($query) {
                $query->where('type', 'non-monetary')->where('status', 'completed');
            })
            ->distinct('donor_email')
            ->count('donor_email');

        $query = Campaign::withCount('donations');

        // Apply date range filter
        if ($request->has('date_range')) {
            $days = $request->date_range;
            $query->where('created_at', '>=', Carbon::now()->subDays($days));
        }

        // Apply campaign filter
        if ($request->has('campaign_id') && $request->campaign_id) {
            $query->where('id', $request->campaign_id);
        }

        $campaigns = $query->get();

        // Get recent donations with filters
        $donationsQuery = Donation::with(['donor', 'campaign']);

        if ($request->has('date_range')) {
            $days = $request->date_range;
            $donationsQuery->where('created_at', '>=', Carbon::now()->subDays($days));
        }

        if ($request->has('campaign_id') && $request->campaign_id) {
            $donationsQuery->where('campaign_id', $request->campaign_id);
        }

        if ($request->has('status') && $request->status) {
            $donationsQuery->where('status', $request->status);
        }

        $donations = $donationsQuery->latest()->get();
        $recentDonations = $donations->take(10); // Get the 10 most recent donations

        // --- Start: Code to fetch and prepare monthly data for the chart ---
        $currentYear = Carbon::now()->year;
        $startDate = Carbon::create($currentYear, 1, 1)->startOfMonth(); // Start from January of current year

        $monthlyDonations = Donation::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('type', 'monetary') // Assuming you only want monetary donations
            ->whereYear('created_at', $currentYear) // Filter for current year only
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlyLabels = [];
        $monthlyData = [];

        // Generate labels and data for the last 12 months, including months with no donations
        $currentMonth = Carbon::now()->subMonths(11)->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $monthLabel = $currentMonth->format('M Y');
            $monthlyLabels[] = $monthLabel;

            // Find if there is a donation entry for this month
            $donationForMonth = $monthlyDonations->first(function ($donation) use ($currentMonth) {
                return $donation->year === $currentMonth->year && $donation->month === $currentMonth->month;
            });

            $monthlyData[] = $donationForMonth ? $donationForMonth->total_amount : 0;

            $currentMonth->addMonth(); // Move to the next month
        }
        // --- End: Code to fetch and prepare monthly data for the chart ---

        // Pass all necessary data to the view
        return view('admin.donation.reports', compact('campaigns', 'donations', 'monetaryDonationsTotal', 'nonMonetaryDonationsCount', 'campaignsCount', 'donorsCount', 'recentDonations', 'monthlyLabels', 'monthlyData'));
    }

    public function export(Request $request)
    {
        $query = Donation::with(['donor', 'campaign']);

        // Apply filters
        if ($request->has('date_range')) {
            $days = $request->date_range;
            $query->where('created_at', '>=', Carbon::now()->subDays($days));
        }

        if ($request->has('campaign_id') && $request->campaign_id) {
            $query->where('campaign_id', $request->campaign_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $donations = $query->get();

        // Generate CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="donation-reports.csv"',
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['Donor', 'Campaign', 'Amount', 'Date', 'Status', 'Type']);
            
            // Add data
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->donor->name,
                    $donation->campaign->title,
                    $donation->amount,
                    $donation->created_at->format('Y-m-d H:i:s'),
                    $donation->status,
                    $donation->type
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 