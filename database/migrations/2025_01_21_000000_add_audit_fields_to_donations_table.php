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
            // Audit trail fields
            $table->decimal('original_amount', 10, 2)->nullable()->after('amount');
            $table->decimal('confirmed_amount', 10, 2)->nullable()->after('original_amount');
            $table->text('admin_notes')->nullable()->after('notes');
            $table->unsignedBigInteger('edited_by')->nullable()->after('admin_notes');
            $table->timestamp('edited_at')->nullable()->after('edited_by');
            
            // Foreign key for edited_by (assuming you have a users table)
            $table->foreign('edited_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['edited_by']);
            $table->dropColumn([
                'original_amount',
                'confirmed_amount', 
                'admin_notes',
                'edited_by',
                'edited_at'
            ]);
        });
    }
};
