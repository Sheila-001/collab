<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->is_admin) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have admin privileges.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index()
    {
        // Get current month's data
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Get total monetary donations
        $monetaryTotal = Donation::where('type', 'monetary')
            ->where('status', 'completed')
            ->sum('amount');

        // Calculate monetary change
        $lastMonthMonetary = Donation::where('type', 'monetary')
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');
        
        $monetaryChange = $lastMonthMonetary > 0 
            ? (($monetaryTotal - $lastMonthMonetary) / $lastMonthMonetary) * 100 
            : 0;

        // Get count of non-monetary donations
        $nonMonetaryCount = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->count();

        // Calculate non-monetary change
        $lastMonthNonMonetary = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        $nonMonetaryChange = $lastMonthNonMonetary > 0 
            ? (($nonMonetaryCount - $lastMonthNonMonetary) / $lastMonthNonMonetary) * 100 
            : 0;

        // Get campaign total and change
        $campaignTotal = Donation::whereHas('campaign', function($query) {
                $query->where('status', 'active');
            })
            ->where('status', 'completed')
            ->sum('amount');
        
        $lastMonthCampaign = Donation::whereHas('campaign', function($query) use ($lastMonth) {
                $query->where('status', 'active');
            })
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');
        
        $campaignChange = $lastMonthCampaign > 0 
            ? (($campaignTotal - $lastMonthCampaign) / $lastMonthCampaign) * 100 
            : 0;

        // Get donor count and change
        $donorCount = Donation::select('donor_email')
            ->distinct()
            ->count();
        
        $lastMonthDonors = Donation::select('donor_email')
            ->distinct()
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        $donorChange = $lastMonthDonors > 0 
            ? (($donorCount - $lastMonthDonors) / $lastMonthDonors) * 100 
            : 0;

        // Get paginated donations
        $donations = Donation::with(['campaign'])
            ->latest()
            ->paginate(10);

        // Get pending drop-offs
        $pendingDropoffs = Donation::where('type', 'non-monetary')
            ->where('status', 'pending')
            ->get();

        // Get total pending donations (monetary + non-monetary)
        $pendingDonations = Donation::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'monetaryTotal',
            'monetaryChange',
            'nonMonetaryCount',
            'nonMonetaryChange',
            'campaignTotal',
            'campaignChange',
            'donorCount',
            'donorChange',
            'donations',
            'pendingDropoffs',
            'pendingDonations'
        ));
    }

    public function volunteerIndex()
    {
        $volunteers = Volunteer::latest()->paginate(10);
        $activeVolunteersCount = Volunteer::where('status', 'Active')->count();
        return view('admin.volunteers.index', compact('volunteers', 'activeVolunteersCount'));
    }

    public function approveVolunteer(Volunteer $volunteer)
    {
        $volunteer->status = 'Approved';
        $volunteer->save();
        return back()->with('success', 'Volunteer application approved successfully.');
    }

    public function rejectVolunteer(Volunteer $volunteer)
    {
        $volunteer->status = 'Rejected';
        $volunteer->save();
        return back()->with('success', 'Volunteer application rejected successfully.');
    }

    private function updateCompletedEvents()
    {
        // Update status of completed events
        Event::where('end_date', '<', Carbon::now())
             ->where('status', '!=', 'completed')
             ->update(['status' => 'completed']);
    }

    /**
     * Get real-time donation statistics for the dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDonationStats()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $monetaryTotal = Donation::where('type', 'monetary')
            ->where('status', 'completed')
            ->sum('amount');

        $lastMonthMonetary = Donation::where('type', 'monetary')
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');
        
        $monetaryChange = $lastMonthMonetary > 0 
            ? (($monetaryTotal - $lastMonthMonetary) / $lastMonthMonetary) * 100 
            : 0;

        $nonMonetaryCount = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->count();

        $lastMonthNonMonetary = Donation::where('type', 'non-monetary')
            ->where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        $nonMonetaryChange = $lastMonthNonMonetary > 0 
            ? (($nonMonetaryCount - $lastMonthNonMonetary) / $lastMonthNonMonetary) * 100 
            : 0;

        $donorCount = Donation::select('donor_email')
            ->distinct()
            ->count();
        
        $lastMonthDonors = Donation::select('donor_email')
            ->distinct()
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        $donorChange = $lastMonthDonors > 0 
            ? (($donorCount - $lastMonthDonors) / $lastMonthDonors) * 100 
            : 0;

        $pendingDonations = Donation::where('status', 'pending')->count();

        return response()->json([
            'monetaryTotal' => number_format($monetaryTotal, 2),
            'monetaryChange' => number_format($monetaryChange, 1),
            'nonMonetaryCount' => $nonMonetaryCount,
            'nonMonetaryChange' => number_format($nonMonetaryChange, 1),
            'donorCount' => $donorCount,
            'donorChange' => number_format($donorChange, 1),
            'pendingDonations' => $pendingDonations,
        ]);
    }
}