<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UrgentCampaign;
use Carbon\Carbon;

class UpdateUrgentCampaignStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urgent-campaigns:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update urgent campaign statuses based on end dates and progress';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating urgent campaign statuses...');
        
        $updatedCount = 0;
        
        // Get all active urgent campaigns
        $campaigns = UrgentCampaign::where('is_active', true)->get();
        
        foreach ($campaigns as $campaign) {
            $shouldUpdate = false;
            $newStatus = null;
            
            // Check if campaign has ended
            if ($campaign->ends_at && $campaign->ends_at <= now()) {
                $campaign->is_active = false;
                $shouldUpdate = true;
                $newStatus = 'ended (past end date)';
            }
            // Check if campaign is fully funded
            elseif ($campaign->progress_percentage >= 100) {
                $campaign->is_active = false;
                $shouldUpdate = true;
                $newStatus = 'completed (100% funded)';
            }
            
            if ($shouldUpdate) {
                $campaign->save();
                $updatedCount++;
                $this->line("Updated: {$campaign->title} - {$newStatus}");
            }
        }
        
        if ($updatedCount > 0) {
            $this->info("Successfully updated {$updatedCount} urgent campaign(s).");
        } else {
            $this->info('No urgent campaigns needed status updates.');
        }
        
        return 0;
    }
}
