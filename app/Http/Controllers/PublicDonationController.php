<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Donation;
use App\Models\Campaign;
use App\Models\UrgentCampaign;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use App\Mail\NonMonetarySubmissionThankYou;
use Carbon\Carbon;

class PublicDonationController extends Controller
{
    public function index()
    {
        // Debug: Let's check what donations exist and their status
        $allDonations = \App\Models\Donation::select('id', 'donor_name', 'status', 'is_acknowledged', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Log for debugging
        \Log::info('All donations in database:', $allDonations->toArray());

        // Fetch recent donors - only approved donations that are acknowledged
        // Admin uses 'approved' status when approving donations
        $recentDonors = \App\Models\Donation::where('status', 'approved')
            ->where('is_acknowledged', true)
            ->orderBy('updated_at', 'desc') // Order by when admin approved (updated_at)
            ->take(6) // Show 6 recent donors instead of 5
            ->get();

        // Log for debugging
        \Log::info('Recent donors found:', $recentDonors->toArray());

        // Get active urgent campaigns
        $urgentCampaigns = UrgentCampaign::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('ends_at')
                      ->orWhere('ends_at', '>', Carbon::now());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass the recent donors and urgent campaigns to the view
        return view('donation.donation', compact('recentDonors', 'urgentCampaigns'));
    }

    /**
     * Show the monetary donation form.
     */
    public function monetaryDonation()
    {
        return view('donation.monetary');
    }

    /**
     * Show the non-monetary donation form.
     */
    public function nonMonetaryDonation()
    {
        return view('donation.nonmonetary');
    }

    /**
     * Handle the monetary donation form submission.
     */
    public function submitMonetaryDonation(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:bank_transfer,gcash',
            'amount' => 'required|numeric|min:1',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'required|string|max:25',
            'proof' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Max 2MB
            'message' => 'nullable|string',
            'donation_preference' => 'required|in:anonymous,acknowledged', // Add validation for the preference
            'campaign_id' => 'nullable|exists:campaigns,id', // Add validation for campaign_id
            'urgent_campaign_id' => 'nullable|exists:urgent_campaigns,id', // Add validation for urgent_campaign_id
        ]);

        // Additional validation for campaign end date
        if ($request->campaign_id) {
            $campaign = \App\Models\Campaign::find($request->campaign_id);
            if ($campaign && !$campaign->isAcceptingDonations()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['campaign_id' => ['This campaign is no longer accepting donations.']]
                ], 422);
            }
        }

        // Additional validation for urgent campaign end date
        if ($request->urgent_campaign_id) {
            $urgentCampaign = \App\Models\UrgentCampaign::find($request->urgent_campaign_id);
            if ($urgentCampaign && !$urgentCampaign->isAcceptingDonations()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['urgent_campaign_id' => ['This urgent campaign is no longer accepting donations.']]
                ], 422);
            }
        }

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Process the donation (e.g., save to database, send email)
        
        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('monetary', 'public');
        }

        // Determine the is_acknowledged value based on the preference
        $isAcknowledged = ($request->donation_preference === 'acknowledged');
        $isAnonymous = !$isAcknowledged; // If not acknowledged, then it's anonymous
        
        $donation = \App\Models\Donation::create([
            'type' => 'monetary',
            'campaign_id' => $request->campaign_id, // Add campaign_id to the donation
            'urgent_campaign_id' => $request->urgent_campaign_id, // Add urgent_campaign_id to the donation
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_phone' => $request->donor_phone,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'description' => null, // Description is for non-monetary donations
            'status' => 'pending', // Initial status - requires admin approval
            'transaction_id' => null, // You might get this from a payment gateway
            'proof_path' => $proofPath,
            'notes' => $request->message, // Store the message in notes field
            'is_acknowledged' => $isAcknowledged,
            'is_anonymous' => $isAnonymous,
        ]);

        // For this example, we'll just return a success response.
        return response()->json(['success' => true, 'message' => 'Donation submitted successfully!', 'donation_id' => $donation->id]);
    }

    /**
     * Handle the non-monetary donation form submission.
     */
    public function submitNonMonetaryDonation(Request $request)
    {
        // Force a log entry to check if logging is working
        Log::info('Attempting to submit non-monetary donation - New Log Entry Test.');

        // Log the incoming request data
        Log::info('Non-monetary donation request data:', $request->all());

        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'category' => 'required|string|max:255',
                'donor_name' => 'required|string|max:255',
                'donor_email' => 'required|email|max:255',
                'donor_phone' => 'required|string|max:25',
                'image' => 'required|file|image|max:2048', // Max 2MB, image file types
                'expected_date' => 'required|date|after_or_equal:today',
                'description' => 'nullable|string', // Made optional
                'donation_preference' => 'required|in:anonymous,acknowledged',
                'quantity' => 'required|string',
                'other_item_name' => 'nullable|string|max:255',

                // Category-specific field validations
                'hygiene_condition' => 'nullable|in:yes,no',
                'clothing_condition' => 'nullable|in:new,gently_used',
                'bedding_condition' => 'nullable|in:new,gently_used',
                'health_condition' => 'nullable|in:yes,no',
                'health_type' => 'nullable|in:vitamins,first_aid,medicine,others',
                'school_condition' => 'nullable|in:new,slightly_used',
                'school_type' => 'nullable|in:notebooks,pens,bag,uniform,others',
                'tech_condition' => 'nullable|in:yes,no',
                'tech_type' => 'nullable|string|max:255',
                'food_condition' => 'nullable|in:yes,no',
                'food_type' => 'nullable|in:canned_goods,rice,snacks,beverages,others',
                'other_condition' => 'nullable|in:new,gently_used',
                'other_additional_info' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            // Add this log to inspect the request data before saving
            Log::info('Request data before processing donation:', ['expected_date' => $request->expected_date, 'all' => $request->all()]);

            // Process the donation (e.g., save to database, send email)

            $imagePath = null;
            if ($request->hasFile('image')) {
                Log::info('Attempting to store image file.');
                $imagePath = $request->file('image')->store('non-monetary', 'public');
                Log::info('Image file stored at path:' . $imagePath);
            }

            // Collect category-specific data
            $categoryData = [];
            $category = $request->category;

            // Map category values to their actual names for data storage
            $categoryMap = [
                'Books' => 'Personal Hygiene',
                'Clothes' => 'Clothing & Footwear',
                'Electronics' => 'Bedding & Linens',
                'Furniture' => 'Health & Wellness',
                'Household Items' => 'School Supplies',
                'Toys' => 'Technology for Learning',
                'Food' => 'Food Items',
                'Others' => 'Others'
            ];

            $actualCategory = $categoryMap[$category] ?? $category;

            // Collect category-specific fields based on category
            switch($category) {
                case 'Books': // Personal Hygiene
                    if ($request->hygiene_condition) {
                        $categoryData['condition'] = $request->hygiene_condition;
                        $categoryData['sealed_unused'] = $request->hygiene_condition === 'yes';
                    }
                    break;
                case 'Clothes': // Clothing & Footwear
                    if ($request->clothing_condition) {
                        $categoryData['condition'] = $request->clothing_condition;
                    }
                    break;
                case 'Electronics': // Bedding & Linens
                    if ($request->bedding_condition) {
                        $categoryData['condition'] = $request->bedding_condition;
                    }
                    break;
                case 'Furniture': // Health & Wellness
                    if ($request->health_condition) {
                        $categoryData['sealed_not_expired'] = $request->health_condition === 'yes';
                    }
                    if ($request->health_type) {
                        $categoryData['item_type'] = $request->health_type;
                    }
                    break;
                case 'Household Items': // School Supplies
                    if ($request->school_condition) {
                        $categoryData['condition'] = $request->school_condition;
                    }
                    if ($request->school_type) {
                        $categoryData['supply_type'] = $request->school_type;
                    }
                    break;
                case 'Toys': // Technology for Learning
                    if ($request->tech_condition) {
                        $categoryData['working_condition'] = $request->tech_condition === 'yes';
                    }
                    if ($request->tech_type) {
                        $categoryData['item_type'] = $request->tech_type;
                    }
                    break;
                case 'Food': // Food Items
                    if ($request->food_condition) {
                        $categoryData['unopened_not_expired'] = $request->food_condition === 'yes';
                    }
                    if ($request->food_type) {
                        $categoryData['food_type'] = $request->food_type;
                    }
                    break;
                case 'Others':
                    if ($request->other_item_name) {
                        $categoryData['item_name'] = $request->other_item_name;
                    }
                    if ($request->other_condition) {
                        $categoryData['condition'] = $request->other_condition;
                    }
                    if ($request->other_additional_info) {
                        $categoryData['additional_info'] = $request->other_additional_info;
                    }
                    break;
            }

            // Determine the is_acknowledged and is_anonymous values based on the preference
            $isAcknowledged = ($request->donation_preference === 'acknowledged');
            $isAnonymous = !$isAcknowledged; // If not acknowledged, then it's anonymous

            // Create a new record in the donations table
            $donation = new \App\Models\Donation();
            $donation->type = 'non-monetary';
            $donation->status = 'pending';
            $donation->donor_name = $request->donor_name;
            $donation->donor_email = $request->donor_email;
            $donation->donor_phone = $request->donor_phone;
            $donation->amount = null; // Amount is null for non-monetary donations
            $donation->payment_method = null; // Payment method is null for non-monetary donations
            $donation->transaction_id = null;
            $donation->proof_path = $imagePath; // Store image path in proof_path
            $donation->is_acknowledged = $isAcknowledged;
            $donation->is_anonymous = $isAnonymous;
            $donation->expected_date = $request->expected_date;
            $donation->description = $request->description; // Use description instead of notes
            $donation->category = $actualCategory; // Store the actual category name
            $donation->category_data = $categoryData; // Store category-specific data as JSON
            $donation->quantity = $request->quantity; // Save the quantity
            $donation->item_name = $actualCategory; // Explicitly set item_name from category for display in admin

            Log::info('Donation data before saving:', $donation->toArray());
            Log::info('Attempting to save donation to database.');
            // Save the donation to the database
            $donation->save();
            Log::info('Donation saved successfully.');

            // Send thank you email to donor
            try {
                Log::info('Starting email sending process...', [
                    'donor_email' => $donation->donor_email,
                    'donation_id' => $donation->id,
                    'donation_type' => $donation->type
                ]);

                // Verify the email configuration
                Log::info('Mail configuration:', [
                    'mailer' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'from_address' => config('mail.from.address'),
                    'from_name' => config('mail.from.name')
                ]);

                Mail::to($donation->donor_email)->send(new NonMonetarySubmissionThankYou($donation));
                Log::info('Thank you email sent successfully to: ' . $donation->donor_email);
            } catch (\Exception $e) {
                Log::error('Failed to send thank you email: ' . $e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
                // Continue with the response even if email fails
            }

            // For this example, we'll just return a success response.
            return response()->json(['success' => true, 'message' => 'Non-monetary donation submitted successfully!']);
        } catch (ValidationException $e) {
             Log::error('Validation Error submitting non-monetary donation: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
             return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            // Log the database exception
            Log::error('Database Error submitting non-monetary donation: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            // Return an error response with the database error message
            return response()->json(['success' => false, 'message' => 'A database error occurred while submitting your donation.', 'error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            // Log any other exception
            Log::error('Error submitting non-monetary donation: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            // Return a generic error response with the exception message
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred while submitting your donation.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateDonationPreference(Request $request, Donation $donation)
    {
        try {
            $request->validate([
                'donation_preference' => 'required|in:anonymous,acknowledged',
            ]);

            $isAcknowledged = ($request->donation_preference === 'acknowledged');
            $isAnonymous = !$isAcknowledged;

            $donation->update([
                'is_acknowledged' => $isAcknowledged,
                'is_anonymous' => $isAnonymous,
            ]);

            return response()->json(['success' => true, 'message' => 'Donation preference updated successfully!']);
        } catch (\Exception $e) {
            Log::error('Error updating donation preference: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'donation_id' => $donation->id,
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to update donation preference.'], 500);
        }
    }

    // You might add other methods here for non-monetary donations or campaigns
}