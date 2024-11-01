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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("fees");
            $table->string("paid");
            $table->string("tooth");
            $table->text("treatment");
            $table->unsignedBigInteger("patient_id");
            $table->boolean("tax_invoice")->default(false);
            $table->foreign("patient_id")->on("patients")->references("id")->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('invoices');
    }
};
