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
            if (!Schema::hasColumn('donations', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('donations', 'condition')) {
                $table->string('condition')->nullable();
            }
            if (!Schema::hasColumn('donations', 'quantity')) {
                $table->integer('quantity')->nullable()->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (Schema::hasColumn('donations', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('donations', 'condition')) {
                $table->dropColumn('condition');
            }
            if (Schema::hasColumn('donations', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};
