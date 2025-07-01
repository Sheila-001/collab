<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;

class UpdateCampaignTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:update-totals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update total_donations field for all campaigns based on completed donations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating campaign totals...');
        
        $campaigns = Campaign::all();
        $updated = 0;
        
        foreach ($campaigns as $campaign) {
            $oldTotal = $campaign->total_donations;
            $campaign->updateTotalDonations();
            
            if ($oldTotal != $campaign->total_donations) {
                $updated++;
                $this->line("Campaign '{$campaign->title}': {$oldTotal} -> {$campaign->total_donations}");
            }
        }
        
        $this->info("Updated {$updated} campaigns out of {$campaigns->count()} total campaigns.");
        
        return 0;
    }
}
