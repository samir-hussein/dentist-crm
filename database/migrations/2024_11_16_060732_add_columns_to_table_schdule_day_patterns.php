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
        Schema::table('schdule_day_patterns', function (Blueprint $table) {
            $table->unsignedBigInteger("doctor_id")->nullable();
            $table->unsignedBigInteger("branch_id")->nullable();
            $table->foreign("branch_id")->references("id")->on("branches")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("doctor_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->unique(['time', 'doctor_id', 'schdule_day_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schdule_day_patterns', function (Blueprint $table) {
            $table->dropForeign(["branch_id", "doctor_id"]);
            $table->dropUnique(['time', 'doctor_id']);
        });
    }
};
