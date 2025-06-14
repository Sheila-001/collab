<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Donation;
use App\Models\Campaign;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class PublicDonationController extends Controller
{
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
            'donor_phone' => 'required|string|max:20',
            'proof' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Max 2MB
            'message' => 'nullable|string',
            'donation_preference' => 'required|in:anonymous,acknowledged', // Add validation for the preference
        ]);

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
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_phone' => $request->donor_phone,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'description' => null, // Description is for non-monetary donations
            'status' => 'pending', // Initial status
            'transaction_id' => null, // You might get this from a payment gateway
            'proof_path' => $proofPath,
            'notes' => $request->notes, // Store the optional note in notes
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
        // Log the incoming request data
        Log::info('Non-monetary donation request data:', $request->all());

        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'category' => 'required|string|max:255',
                'condition' => 'required|string|max:255',
                'donor_name' => 'required|string|max:255',
                'donor_email' => 'required|email|max:255',
                'donor_phone' => 'required|string|max:20',
                'image' => 'required|file|image|max:2048', // Max 2MB, image file types
                'expected_date' => 'required|date',
                'notes' => 'nullable|string',
                'donation_preference' => 'required|in:anonymous,acknowledged', // Add validation for the preference
                'quantity' => 'required|string', // Changed from integer to string
                'other_item_name' => 'nullable|string|max:255', // Add validation for other item name
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

            // Determine the is_acknowledged and is_anonymous values based on the preference
            $isAcknowledged = ($request->donation_preference === 'acknowledged');
            $isAnonymous = !$isAcknowledged; // If not acknowledged, then it's anonymous

            // Create a new record in the donations table
            $donation = new \App\Models\Donation([
                'type' => 'non-monetary',
                'donor_name' => $request->donor_name,
                'donor_email' => $request->donor_email,
                'donor_phone' => $request->donor_phone,
                'amount' => null, // Amount is null for non-monetary donations
                'payment_method' => null, // Payment method is null for non-monetary donations
                'status' => 'pending', // Initial status
                'transaction_id' => null,
                'proof_path' => $imagePath, // Store image path in proof_path
                'is_acknowledged' => $isAcknowledged,
                'is_anonymous' => $isAnonymous,
                'expected_date' => $request->expected_date,
                'notes' => $request->notes,
                'category' => $request->category, // Store the selected or specified category
                'condition' => $request->condition,
                'quantity' => $request->quantity, // Save the quantity
                'other_item_name' => null, // other_item_name is no longer used with the new frontend approach
            ]);

            Log::info('Attempting to save donation to database.');
            // Save the donation to the database
            $donation->save();
            Log::info('Donation saved successfully.');

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