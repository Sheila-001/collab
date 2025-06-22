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
            // Add donor information fields
            if (!Schema::hasColumn('donations', 'donor_name')) {
                $table->string('donor_name')->nullable();
            }
            if (!Schema::hasColumn('donations', 'donor_email')) {
                $table->string('donor_email')->nullable();
            }
            if (!Schema::hasColumn('donations', 'donor_phone')) {
                $table->string('donor_phone')->nullable();
            }
            if (!Schema::hasColumn('donations', 'transaction_id')) {
                $table->string('transaction_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn([
                'donor_name',
                'donor_email', 
                'donor_phone',
                'transaction_id'
            ]);
        });
    }
};
