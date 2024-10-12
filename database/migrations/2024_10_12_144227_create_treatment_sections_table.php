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
        Schema::create('treatment_sections', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->boolean("multi_selection")->default(false);
            $table->unsignedBigInteger("treatment_type_id");
            $table->foreign("treatment_type_id")->references("id")->on("treatment_types")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_sections');
    }
};
