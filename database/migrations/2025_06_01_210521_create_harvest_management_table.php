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
        Schema::create('harvest_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_data_id')->constrained('farming_data')->onDelete('cascade');
            $table->enum('harvesting_type', ['Manual', 'Mechanical']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_management');
    }
};
