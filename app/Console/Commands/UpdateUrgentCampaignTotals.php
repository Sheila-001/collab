<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UrgentCampaign;

class UpdateUrgentCampaignTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urgent-campaigns:update-totals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update urgent campaign donation totals based on completed donations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating urgent campaign donation totals...');
        
        $campaigns = UrgentCampaign::all();
        $updatedCount = 0;
        
        foreach ($campaigns as $campaign) {
            $oldTotal = $campaign->current_amount;
            $campaign->updateTotalDonations();
            
            if ($oldTotal != $campaign->current_amount) {
                $updatedCount++;
                $this->line("Updated: {$campaign->title} - ₱{$oldTotal} → ₱{$campaign->current_amount}");
            }
        }
        
        if ($updatedCount > 0) {
            $this->info("Successfully updated {$updatedCount} urgent campaign total(s).");
        } else {
            $this->info('All urgent campaign totals are already up to date.');
        }
        
        return 0;
    }
}
