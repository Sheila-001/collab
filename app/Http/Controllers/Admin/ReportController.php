<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Volunteer;
use Carbon\Carbon;
use App\Models\Campaign;
use App\Models\Donor;

class ReportController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalMonetaryDonations = Donation::where('type', 'monetary')->sum('amount');
        $totalNonMonetaryDonations = Donation::where('type', 'non-monetary')->count();
        $totalCampaigns = Campaign::count();
        $totalDonors = Donor::count();

        // Get monthly data for the last 12 months
        $monthlyLabels = [];
        $monthlyMonetaryData = [];
        $monthlyNonMonetaryData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyMonetaryData[] = Donation::where('type', 'monetary')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');

            $monthlyNonMonetaryData[] = Donation::where('type', 'non-monetary')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Get annual data for the last 5 years
        $annualLabels = [];
        $annualMonetaryData = [];
        $annualNonMonetaryData = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $annualLabels[] = $year;

            $annualMonetaryData[] = Donation::where('type', 'monetary')
                ->whereYear('created_at', $year)
                ->sum('amount');

            $annualNonMonetaryData[] = Donation::where('type', 'non-monetary')
                ->whereYear('created_at', $year)
                ->count();
        }

        return view('admin.reports.index', compact(
            'totalMonetaryDonations',
            'totalNonMonetaryDonations',
            'totalCampaigns',
            'totalDonors',
            'monthlyLabels',
            'monthlyMonetaryData',
            'monthlyNonMonetaryData',
            'annualLabels',
            'annualMonetaryData',
            'annualNonMonetaryData'
        ));
    }

    public function monetary()
    {
        // Get total amount and count
        $totalAmount = Donation::where('type', 'monetary')->sum('amount');
        $totalCount = Donation::where('type', 'monetary')->count();

        // Get monthly data for the last 12 months
        $monthlyLabels = [];
        $monthlyData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyData[] = Donation::where('type', 'monetary')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
        }

        // Get annual data for the last 5 years
        $annualLabels = [];
        $annualData = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $annualLabels[] = $year;

            $annualData[] = Donation::where('type', 'monetary')
                ->whereYear('created_at', $year)
                ->sum('amount');
        }

        // Get payment method distribution
        $paymentMethodData = Donation::where('type', 'monetary')
            ->selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method')
            ->toArray();

        return view('admin.reports.monetary', compact(
            'totalAmount',
            'totalCount',
            'monthlyLabels',
            'monthlyData',
            'annualLabels',
            'annualData',
            'paymentMethodData'
        ));
    }

    public function nonMonetary()
    {
        // Get total count
        $totalCount = Donation::where('type', 'non-monetary')->count();

        // Get monthly data for the last 12 months
        $monthlyLabels = [];
        $monthlyData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyData[] = Donation::where('type', 'non-monetary')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Get annual data for the last 5 years
        $annualLabels = [];
        $annualData = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $annualLabels[] = $year;

            $annualData[] = Donation::where('type', 'non-monetary')
                ->whereYear('created_at', $year)
                ->count();
        }

        // Get category distribution
        $categoryData = Donation::where('type', 'non-monetary')
            ->selectRaw('item_category, COUNT(*) as count')
            ->groupBy('item_category')
            ->pluck('count', 'item_category')
            ->toArray();

        // Get recent donations
        $recentDonations = Donation::where('type', 'non-monetary')
            ->with('donor')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.non-monetary', compact(
            'totalCount',
            'monthlyLabels',
            'monthlyData',
            'annualLabels',
            'annualData',
            'categoryData',
            'recentDonations'
        ));
    }

    public function donors()
    {
        // Get total donors
        $totalDonors = Donor::count();

        // Get monthly data for the last 12 months
        $monthlyLabels = [];
        $monthlyData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyData[] = Donor::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Get donor type distribution
        $donorTypeData = Donor::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // Get top donors by amount
        $topDonorsByAmount = Donor::withCount(['donations as total_amount' => function ($query) {
                $query->where('type', 'monetary')->select(\DB::raw('SUM(amount)'));
            }])
            ->orderByDesc('total_amount')
            ->take(5)
            ->get();

        // Get top donors by frequency
        $topDonorsByFrequency = Donor::withCount('donations')
            ->orderByDesc('donations_count')
            ->take(5)
            ->get();

        // Get recent donors
        $recentDonors = Donor::withCount('donations')
            ->withMax('donations', 'created_at')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($donor) {
                $donor->last_donation_date = $donor->donations_max_created_at;
                return $donor;
            });

        return view('admin.reports.donors', compact(
            'totalDonors',
            'monthlyLabels',
            'monthlyData',
            'donorTypeData',
            'topDonorsByAmount',
            'topDonorsByFrequency',
            'recentDonors'
        ));
    }

    public function campaigns()
    {
        // Get total campaigns
        $totalCampaigns = Campaign::count();

        // Get campaign data
        $campaigns = Campaign::withCount('donations')
            ->withSum('donations', 'amount')
            ->get();

        // Get campaign labels and data for charts
        $campaignLabels = $campaigns->pluck('name')->toArray();
        $campaignDonations = $campaigns->pluck('donations_count')->toArray();
        $campaignAmounts = $campaigns->pluck('donations_sum_amount')->toArray();

        // Get campaign status distribution
        $campaignStatusData = Campaign::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.reports.campaigns', compact(
            'totalCampaigns',
            'campaigns',
            'campaignLabels',
            'campaignDonations',
            'campaignAmounts',
            'campaignStatusData'
        ));
    }

    public function donations()
    {
        $donations = Donation::with(['donor', 'campaign'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalDonations = $donations->sum('amount');
        $monthlyDonations = $donations->groupBy(function($donation) {
            return Carbon::parse($donation->created_at)->format('M Y');
        });

        return view('admin.reports.donations', compact('donations', 'totalDonations', 'monthlyDonations'));
    }

    public function events()
    {
        $events = Event::with(['volunteers', 'donations'])
            ->orderBy('date', 'desc')
            ->get();

        $totalEvents = $events->count();
        $totalParticipants = $events->sum(function($event) {
            return $event->volunteers->count();
        });

        return view('admin.reports.events', compact('events', 'totalEvents', 'totalParticipants'));
    }

    public function volunteers()
    {
        $volunteers = Volunteer::with(['events', 'donations'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalVolunteers = $volunteers->count();
        $activeVolunteers = $volunteers->where('status', 'active')->count();

        return view('admin.reports.volunteers', compact('volunteers', 'totalVolunteers', 'activeVolunteers'));
    }

    public function financial()
    {
        $donations = Donation::with(['donor', 'campaign'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalIncome = $donations->sum('amount');
        $monthlyIncome = $donations->groupBy(function($donation) {
            return Carbon::parse($donation->created_at)->format('M Y');
        });

        return view('admin.reports.financial', compact('donations', 'totalIncome', 'monthlyIncome'));
    }
} 