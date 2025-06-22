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
            // Add missing columns for non-monetary donations
            if (!Schema::hasColumn('donations', 'item_category')) {
                $table->string('item_category')->nullable()->after('item_name');
            }
            if (!Schema::hasColumn('donations', 'category')) {
                $table->string('category')->nullable()->after('item_category');
            }
            if (!Schema::hasColumn('donations', 'condition')) {
                $table->string('condition')->nullable()->after('category');
            }
            if (!Schema::hasColumn('donations', 'description')) {
                $table->text('description')->nullable()->after('condition');
            }
            if (!Schema::hasColumn('donations', 'quantity')) {
                $table->integer('quantity')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $columns = ['item_category', 'category', 'condition', 'description', 'quantity'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('donations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
