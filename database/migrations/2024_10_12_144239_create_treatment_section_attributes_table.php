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
        Schema::create('treatment_section_attributes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("has_inputs")->default(false);
            $table->unsignedBigInteger('treatment_section_id');
            $table->foreign("treatment_section_id")->references("id")->on("treatment_sections")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_section_attributes');
    }
};
