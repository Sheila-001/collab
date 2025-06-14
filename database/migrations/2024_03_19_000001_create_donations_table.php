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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type'); // monetary, non-monetary
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_category')->nullable();
            $table->integer('item_quantity')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
}; 