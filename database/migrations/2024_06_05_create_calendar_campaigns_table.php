<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('calendar_categories')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_campaigns');
    }
}; 