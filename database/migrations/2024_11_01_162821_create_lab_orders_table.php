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
        Schema::create('lab_orders', function (Blueprint $table) {
            $table->id();
            $table->text("work");
            $table->string("cost");
            $table->boolean("done")->default(false);
            $table->json("custom_data")->nullable();
            $table->string("tooth");
            $table->date("sent");
            $table->date("received")->nullable();
            $table->unsignedBigInteger("patient_id");
            $table->foreign("patient_id")->on("patients")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("lab_id");
            $table->foreign("lab_id")->on("labs")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("treatment_detail_id");
            $table->foreign("treatment_detail_id")->on("treatment_details")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_orders');
    }
};
