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
        Schema::create('treatment_details', function (Blueprint $table) {
            $table->id();
            $table->string("tooth");
            $table->json("data");
            $table->unsignedBigInteger("patient_id");
            $table->foreign("patient_id")->on("patients")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("diagnose_id");
            $table->foreign("diagnose_id")->on("diagnoses")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_details');
    }
};
