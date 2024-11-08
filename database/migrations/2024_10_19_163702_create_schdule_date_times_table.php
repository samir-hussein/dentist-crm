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
        Schema::create('schdule_date_times', function (Blueprint $table) {
            $table->id();
            $table->timestamp("time")->unique()->nullable();
            $table->timestamp("manually_updated_time")->nullable();
            $table->boolean("is_manually_updated")->default(false);
            $table->boolean("is_deleted")->default(false);
            $table->unsignedBigInteger('schdule_date_id');
            $table->foreign('schdule_date_id')->references('id')->on('schdule_dates')->onDelete('cascade')->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schdule_date_times');
    }
};
