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
        Schema::create('water_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_data_id')->constrained('farming_data')->onDelete('cascade');
            $table->enum('type', ['nia', 'supplementary'])->default('supplementary');
            $table->boolean('is_package')->default(false);
            $table->decimal('package_total_cost', 10, 2)->nullable();
            $table->decimal('nia_total_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_management');
    }
};
