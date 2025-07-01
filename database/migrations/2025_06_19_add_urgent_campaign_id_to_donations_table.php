<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->foreignId('urgent_campaign_id')->nullable()->constrained('urgent_campaigns')->onDelete('set null')->after('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['urgent_campaign_id']);
            $table->dropColumn('urgent_campaign_id');
        });
    }
};
