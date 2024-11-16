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
        Schema::table('schdule_date_times', function (Blueprint $table) {
            $table->dropUnique(['time']); // Drop unique index on 'time' column
            $table->unsignedBigInteger("doctor_id")->nullable();
            $table->unsignedBigInteger("branch_id")->nullable();
            $table->foreign("branch_id")->references("id")->on("branches")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("doctor_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->unique(['time', 'doctor_id', 'schdule_date_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schdule_date_times', function (Blueprint $table) {
            $table->dropUnique(['time', 'doctor_id', 'schdule_date_id']);
            $table->dropForeign(["branch_id"]);
            $table->dropForeign(["doctor_id"]);
        });
    }
};
