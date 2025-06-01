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
        Schema::create('other_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_data_id')->constrained('farming_data')->onDelete('cascade');
            // Hauling
            $table->integer('hauling_qty')->nullable();
            $table->decimal('hauling_unit_cost', 10, 2)->nullable();
            $table->decimal('hauling_total_cost', 10, 2)->nullable();

            // Permanent Hired Labor
            $table->integer('hired_bags')->nullable();
            $table->decimal('hired_avg_bag_weight', 10, 2)->nullable();
            $table->decimal('hired_price_per_kg', 10, 2)->nullable();
            $table->decimal('hired_percent_share', 5, 2)->nullable();
            $table->decimal('hired_total_cost', 10, 2)->nullable();

            // Land Ownership (Amilyar)
            $table->decimal('land_ownership_fee', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_expenses');
    }
};
