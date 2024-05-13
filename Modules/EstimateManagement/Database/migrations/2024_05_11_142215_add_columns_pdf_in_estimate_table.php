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
        Schema::table('estimates', function (Blueprint $table) {
            $table->string('unit');
            $table->string('rate');
            $table->string('verification');
            $table->string('verification_2');
            $table->string('bank_translation');
            $table->string('layout_charges');
            $table->string('layout_charges_2');
            $table->string('lang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            
        });
    }
};
