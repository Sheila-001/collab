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
            // Change quantity from integer to string to allow descriptive quantities
            if (Schema::hasColumn('donations', 'quantity')) {
                $table->string('quantity')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Revert quantity back to integer
            if (Schema::hasColumn('donations', 'quantity')) {
                $table->integer('quantity')->nullable()->change();
            }
        });
    }
};
