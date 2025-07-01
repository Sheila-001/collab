<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\Campaign;
use Carbon\Carbon;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there's at least one campaign to attach donations to
        $campaign = Campaign::first();

        if (! $campaign) {
            // If no campaign exists, create a dummy one
            $campaign = Campaign::create([
                'title' => 'Dummy Campaign',
                'description' => 'This is a dummy campaign for testing.',
                'goal_amount' => 10000.00,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(20),
                'status' => 'active',
                'type' => 'monetary',
                'category_id' => null, // Assuming category_id is nullable or you have categories
            ]);
        }

        // Create 10 dummy completed monetary donations
        for ($i = 0; $i < 10; $i++) {
            Donation::create([
                'campaign_id' => $campaign->id,
                'type' => 'monetary',
                'amount' => rand(100, 1000) * 10, // Random amount between 1000 and 10000
                'donor_name' => 'Donor ' . ($i + 1),
                'donor_email' => 'donor' . ($i + 1) . '@example.com',
                'status' => 'completed',
                'transaction_id' => 'TRANS-' . uniqid(),
                'proof_of_payment' => null,
                'notes' => 'Dummy donation for testing.',
            ]);
        }

        // Create 3 dummy completed non-monetary donations
        for ($i = 0; $i < 3; $i++) {
            Donation::create([
                'campaign_id' => $campaign->id,
                'type' => 'non-monetary',
                'item_name' => 'Item ' . ($i + 1),
                'quantity' => rand(1, 5),
                'donor_name' => 'Non-Monetary Donor ' . ($i + 1),
                'donor_email' => 'nonmonetary' . ($i + 1) . '@example.com',
                'status' => 'completed',
                'dropoff_date' => Carbon::now()->addDays(rand(1, 7)),
                'notes' => 'Dummy non-monetary donation for testing.',
            ]);
        }
    }
}
