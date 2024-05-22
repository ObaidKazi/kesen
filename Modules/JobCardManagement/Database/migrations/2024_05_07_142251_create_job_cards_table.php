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
            $table->string('protocol_no')->nullable();
            $table->string('client_id')->nullable();
            $table->string('estimate_id')->nullable();
            $table->string('description')->nullable();
            $table->string('handled_by')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('bill_date')->nullable();
            $table->string('informed_to')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('pd')->nullable();
            $table->string('cr')->nullable();
            $table->string('cn')->nullable();
            $table->string('dv')->nullable();
            $table->string('qc')->nullable();
            $table->string('sent_date')->nullable();
            $table->string('site_specific')->nullable();
            $table->string('site_specific_path')->nullable();
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
