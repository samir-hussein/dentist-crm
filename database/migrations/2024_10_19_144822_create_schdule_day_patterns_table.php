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
        Schema::create('schdule_day_patterns', function (Blueprint $table) {
            $table->id();
            $table->time("time");
            $table->unsignedBigInteger('schdule_day_id');
            $table->foreign("schdule_day_id")->on("schdule_days")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schdule_day_patterns');
    }
};
