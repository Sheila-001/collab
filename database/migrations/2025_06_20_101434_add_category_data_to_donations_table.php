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
            // Add JSON field to store category-specific data
            if (!Schema::hasColumn('donations', 'category_data')) {
                $table->json('category_data')->nullable()->after('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (Schema::hasColumn('donations', 'category_data')) {
                $table->dropColumn('category_data');
            }
        });
    }
};
