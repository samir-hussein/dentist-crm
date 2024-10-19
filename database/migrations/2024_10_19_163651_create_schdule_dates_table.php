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
        Schema::create('schdule_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("schdule_day_id");
            $table->date("date")->unique();
            $table->boolean("is_holiday")->default(false);
            $table->text("note")->nullable();
            $table->foreign("schdule_day_id")->references("id")->on("schdule_days")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schdule_dates');
    }
};
