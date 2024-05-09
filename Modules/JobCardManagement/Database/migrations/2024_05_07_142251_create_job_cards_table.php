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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('job_card_srno')->autoIncrement();
            $table->string('job_card_no');
            $table->string('date');
            $table->string('protocol_no');
            $table->string('client_name');
            $table->string('description');
            $table->string('handled_by');
            $table->string('bill_no');
            $table->string('bill_date');
            $table->string('informed_to');
            $table->string('invoice_date');
            $table->string('pd');
            $table->string('cr');
            $table->string('cn');
            $table->string('dv');
            $table->string('qc');
            $table->string('sent_date');
            $table->string('site_specific');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_cards');
    }
};
