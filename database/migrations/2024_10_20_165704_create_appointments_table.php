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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("patient_id");
            $table->unsignedBigInteger("doctor_id");
            $table->integer("visit_no");
            $table->unsignedBigInteger("time_id")->nullable();
            $table->text("notes")->nullable();
            $table->boolean("completed")->default(false);
            $table->boolean("notified")->default(false);
            $table->foreign("patient_id")->references("id")->on("patients")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("doctor_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("time_id")->references("id")->on("schdule_date_times")->onDelete("set null")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
