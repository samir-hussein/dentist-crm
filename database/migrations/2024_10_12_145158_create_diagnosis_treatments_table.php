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
        Schema::create('diagnosis_treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagnosis_id');
            $table->unsignedBigInteger('treatment_type_id');
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('treatment_type_id')->references('id')->on('treatment_types')->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_treatments');
    }
};
