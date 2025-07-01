<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('type')->nullable();
            $table->decimal('goal_amount', 10, 2);
            $table->decimal('funds_raised', 10, 2)->default(0);
            $table->string('status')->default('active');
            $table->string('image')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
} 