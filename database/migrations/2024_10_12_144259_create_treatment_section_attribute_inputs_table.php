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
        Schema::create('treatment_section_attribute_inputs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("value")->nullable();
            $table->unsignedBigInteger('treatment_section_attribute_id');
            $table->foreign("treatment_section_attribute_id", "fk_treatment_section_attr_id")->references("id")->on("treatment_section_attributes")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_section_attribute_inputs');
    }
};
