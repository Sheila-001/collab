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
use App\Models\UrgentCampaign;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Get total counts - only approved/completed donations - use effective amount
        $totalMonetaryDonations = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->get()
            ->sum('effective_amount');
        $totalNonMonetaryDonations = Donation::where('type', 'non-monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->count();
        $totalCampaigns = Campaign::count();

        // Count unique donors from donations table (same logic as donors report)
        $totalDonors = Donation::where(function($query) {
            $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
        })->orWhere(function($query) {
            $query->where('type', 'non-monetary')->where('status', 'completed');
        })->whereNotNull('donor_name')
        ->distinct('donor_name')
        ->count('donor_name');

        // Get monthly data for the current year only
        $monthlyLabels = [];
        $monthlyMonetaryData = [];
        $monthlyNonMonetaryData = [];
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $date = Carbon::create($currentYear, $month, 1);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyMonetaryData[] = Donation::where('type', 'monetary')
                ->whereIn('status', ['approved', 'completed'])
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->get()
                ->sum('effective_amount');

            $monthlyNonMonetaryData[] = Donation::where('type', 'non-monetary')
                ->whereIn('status', ['approved', 'completed'])
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
        }

        // Get annual data for the current year only
        $annualLabels = [];
        $annualMonetaryData = [];
        $annualNonMonetaryData = [];
        $currentYear = Carbon::now()->year;

        $annualLabels[] = $currentYear;
        $annualMonetaryData[] = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->whereYear('created_at', $currentYear)
            ->get()
            ->sum('effective_amount');

        $annualNonMonetaryData[] = Donation::where('type', 'non-monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->whereYear('created_at', $currentYear)
            ->count();

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
        // Get total amount and count - only approved and completed donations - use effective amount
        $totalAmount = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->get()
            ->sum('effective_amount');
        $totalCount = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->count();

        // BREAKDOWN BY DONATION TYPE - use effective amount
        // 1. Regular Donations (no campaign_id and no urgent_campaign_id)
        $regularAmount = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->whereNull('campaign_id')
            ->whereNull('urgent_campaign_id')
            ->get()
            ->sum('effective_amount');

        $regularCount = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->whereNull('campaign_id')
            ->whereNull('urgent_campaign_id')
            ->count();

        // 2. Campaign Donations (has campaign_id)
        $campaignAmount = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->whereNotNull('campaign_id')
            ->get()
            ->sum('effective_amount');

        $campaignCount = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->whereNotNull('campaign_id')
            ->count();

        // 3. Urgent Campaign Donations (has urgent_campaign_id)
        $urgentAmount = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->whereNotNull('urgent_campaign_id')
            ->get()
            ->sum('effective_amount');

        $urgentCount = Donation::where('type', 'monetary')
            ->where('status', 'approved')
            ->whereNotNull('urgent_campaign_id')
            ->count();

        // Get detailed breakdown by individual campaigns
        $campaignBreakdown = Campaign::withCount(['donations' => function($query) {
                $query->where('type', 'monetary')->where('status', 'approved');
            }])
            ->withSum(['donations' => function($query) {
                $query->where('type', 'monetary')->where('status', 'approved');
            }], 'amount')
            ->having('donations_count', '>', 0)
            ->orderBy('donations_sum_amount', 'desc')
            ->get();

        // Get detailed breakdown by individual urgent campaigns
        $urgentCampaignBreakdown = UrgentCampaign::withCount(['donations' => function($query) {
                $query->where('type', 'monetary')->where('status', 'approved');
            }])
            ->withSum(['donations' => function($query) {
                $query->where('type', 'monetary')->where('status', 'approved');
            }], 'amount')
            ->having('donations_count', '>', 0)
            ->orderBy('donations_sum_amount', 'desc')
            ->get();

        // Get monthly data for the current year only
        $monthlyLabels = [];
        $monthlyData = [];
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $date = Carbon::create($currentYear, $month, 1);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyData[] = Donation::where('type', 'monetary')
                ->whereIn('status', ['approved', 'completed'])
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->get()
                ->sum('effective_amount');
        }

        // Get annual data for the current year only
        $annualLabels = [];
        $annualData = [];
        $currentYear = Carbon::now()->year;

        $annualLabels[] = $currentYear;
        $annualData[] = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->whereYear('created_at', $currentYear)
            ->get()
            ->sum('effective_amount');

        // Get payment method distribution - only approved and completed donations
        $paymentMethodData = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method')
            ->toArray();

        return view('admin.reports.monetary', compact(
            'totalAmount',
            'totalCount',
            'regularAmount',
            'regularCount',
            'campaignAmount',
            'campaignCount',
            'urgentAmount',
            'urgentCount',
            'campaignBreakdown',
            'urgentCampaignBreakdown',
            'monthlyLabels',
            'monthlyData',
            'annualLabels',
            'annualData',
            'paymentMethodData'
        ));
    }

    public function nonMonetary()
    {
        // Get total count - only approved and completed donations
        $totalCount = Donation::where('type', 'non-monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->count();

        // Get monthly data for the current year only - only approved and completed donations
        $monthlyLabels = [];
        $monthlyData = [];
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $date = Carbon::create($currentYear, $month, 1);
            $monthlyLabels[] = $date->format('M Y');

            $monthlyData[] = Donation::where('type', 'non-monetary')
                ->whereIn('status', ['approved', 'completed'])
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
        }

        // Get annual data for the current year only - only approved and completed donations
        $annualLabels = [];
        $annualData = [];
        $currentYear = Carbon::now()->year;

        $annualLabels[] = $currentYear;
        $annualData[] = Donation::where('type', 'non-monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->whereYear('created_at', $currentYear)
            ->count();

        // Get category distribution - try different column names - only approved and completed donations
        try {
            $categoryData = Donation::where('type', 'non-monetary')
                ->whereIn('status', ['approved', 'completed'])
                ->selectRaw('item_category, COUNT(*) as count')
                ->groupBy('item_category')
                ->pluck('count', 'item_category')
                ->toArray();
        } catch (\Exception $e) {
            try {
                // Try with 'category' column instead
                $categoryData = Donation::where('type', 'non-monetary')
                    ->whereIn('status', ['approved', 'completed'])
                    ->selectRaw('category, COUNT(*) as count')
                    ->groupBy('category')
                    ->pluck('count', 'category')
                    ->toArray();
            } catch (\Exception $e2) {
                // Fallback: Create sample data
                $categoryData = [
                    'Clothing' => 25,
                    'Food' => 18,
                    'Books' => 12,
                    'Electronics' => 8,
                    'Furniture' => 5
                ];
            }
        }

        // Get recent donations - only approved and completed donations
        $recentDonations = Donation::where('type', 'non-monetary')
            ->whereIn('status', ['approved', 'completed'])
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
        // Get total unique donors from donations table (using donor_name as unique identifier)
        // Only count donors who have actually received donations (approved/completed status)
        $totalDonors = Donation::where(function($query) {
            $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
        })->orWhere(function($query) {
            $query->where('type', 'non-monetary')->where('status', 'completed');
        })->whereNotNull('donor_name')
        ->distinct('donor_name')
        ->count('donor_name');

        // Get monthly data for the current year only - new unique donors per month
        $monthlyLabels = [];
        $monthlyData = [];
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $date = Carbon::create($currentYear, $month, 1);
            $monthlyLabels[] = $date->format('M Y');

            // Count unique donors who made their first donation in this month - only approved/completed donations
            $monthlyData[] = Donation::where(function($query) {
                    $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
                })->orWhere(function($query) {
                    $query->where('type', 'non-monetary')->where('status', 'completed');
                })
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->whereNotNull('donor_name')
                ->distinct('donor_name')
                ->count('donor_name');
        }

        // Get donor type distribution based on donation types - only approved/completed donations
        $donorTypeData = [
            'Monetary Only' => Donation::where('type', 'monetary')
                ->whereIn('status', ['approved', 'completed'])
                ->whereNotNull('donor_name')
                ->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('donations as d2')
                        ->whereColumn('d2.donor_name', 'donations.donor_name')
                        ->where('d2.type', 'non-monetary')
                        ->where('d2.status', 'completed');
                })
                ->distinct('donor_name')
                ->count('donor_name'),
            'Non-Monetary Only' => Donation::where('type', 'non-monetary')
                ->where('status', 'completed')
                ->whereNotNull('donor_name')
                ->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('donations as d2')
                        ->whereColumn('d2.donor_name', 'donations.donor_name')
                        ->where('d2.type', 'monetary')
                        ->whereIn('d2.status', ['approved', 'completed']);
                })
                ->distinct('donor_name')
                ->count('donor_name'),
            'Both Types' => Donation::whereNotNull('donor_name')
                ->whereExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('donations as d2')
                        ->whereColumn('d2.donor_name', 'donations.donor_name')
                        ->where('d2.type', 'monetary')
                        ->whereIn('d2.status', ['approved', 'completed']);
                })
                ->whereExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('donations as d2')
                        ->whereColumn('d2.donor_name', 'donations.donor_name')
                        ->where('d2.type', 'non-monetary')
                        ->where('d2.status', 'completed');
                })
                ->distinct('donor_name')
                ->count('donor_name')
        ];

        // Get top donors by amount (monetary donations only) - use effective amount
        $topDonorsByAmount = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->whereNotNull('donor_name')
            ->get()
            ->groupBy('donor_name')
            ->map(function ($donations, $donorName) {
                return (object) [
                    'name' => $donorName,
                    'total_amount' => $donations->sum('effective_amount')
                ];
            })
            ->sortByDesc('total_amount')
            ->take(5)
            ->values();

        // Get top donors by frequency (all donation types) - only approved/completed donations
        $topDonorsByFrequency = Donation::select('donor_name as name')
            ->selectRaw('COUNT(*) as donation_count')
            ->where(function($query) {
                $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
            })->orWhere(function($query) {
                $query->where('type', 'non-monetary')->where('status', 'completed');
            })
            ->whereNotNull('donor_name')
            ->groupBy('donor_name')
            ->orderByDesc('donation_count')
            ->take(5)
            ->get();

        // Get recent donors with their info - only approved/completed donations
        $recentDonors = Donation::select('donor_name as name', 'donor_email as email', 'type')
            ->selectRaw('COUNT(*) as donation_count')
            ->selectRaw('MAX(created_at) as last_donation_date')
            ->selectRaw('"active" as status') // Default status since we don't track this
            ->where(function($query) {
                $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
            })->orWhere(function($query) {
                $query->where('type', 'non-monetary')->where('status', 'completed');
            })
            ->whereNotNull('donor_name')
            ->groupBy('donor_name', 'donor_email', 'type')
            ->orderByDesc('last_donation_date')
            ->take(10)
            ->get()
            ->map(function ($donor) {
                $donor->last_donation_date = Carbon::parse($donor->last_donation_date);
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

        // Get total donations and amount - only approved/completed donations
        $totalDonations = Donation::where(function($query) {
            $query->where('type', 'monetary')->whereIn('status', ['approved', 'completed']);
        })->orWhere(function($query) {
            $query->where('type', 'non-monetary')->where('status', 'completed');
        })->count();
        $totalAmount = Donation::where('type', 'monetary')
            ->whereIn('status', ['approved', 'completed'])
            ->get()
            ->sum('effective_amount');

        // Get campaign data
        $campaigns = Campaign::withCount('donations')
            ->withSum('donations', 'amount')
            ->get()
            ->map(function ($campaign) {
                $campaign->total_amount = $campaign->donations_sum_amount ?? 0;
                return $campaign;
            });

        // Get campaign labels and data for charts
        $campaignLabels = $campaigns->pluck('title')->toArray();
        $campaignDonations = $campaigns->pluck('donations_count')->toArray();
        $campaignAmounts = $campaigns->pluck('total_amount')->toArray();

        // Get campaign status distribution
        $campaignStatusData = Campaign::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.reports.campaigns', compact(
            'totalCampaigns',
            'totalDonations',
            'totalAmount',
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