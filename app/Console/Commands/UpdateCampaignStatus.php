<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use Carbon\Carbon;

class UpdateCampaignStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update campaign status based on end dates and completion';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating campaign statuses...');

        $now = Carbon::now();
        $updated = 0;

        // Update campaigns that have ended
        $endedCampaigns = Campaign::where('status', 'active')
            ->where('end_date', '<', $now)
            ->where('is_archived', false)
            ->get();

        foreach ($endedCampaigns as $campaign) {
            $campaign->update(['status' => 'ended']);
            $updated++;
            $this->line("Campaign '{$campaign->title}' marked as ended (end date: {$campaign->end_date})");
        }

        // Update campaigns that have reached 100% funding (only for running campaigns)
        $completedCampaigns = Campaign::where('status', 'active')
            ->where('start_date', '<=', $now)  // ✅ Must have started
            ->where('end_date', '>=', $now)    // ✅ Must not have ended
            ->where('is_archived', false)
            ->get()
            ->filter(function ($campaign) {
                return $campaign->progress_percentage >= 100;
            });

        foreach ($completedCampaigns as $campaign) {
            $campaign->update(['status' => 'completed']);
            $updated++;
            $this->line("Campaign '{$campaign->title}' marked as completed (100% funded)");
        }

        $this->info("Updated {$updated} campaigns.");

        return 0;
    }
}
