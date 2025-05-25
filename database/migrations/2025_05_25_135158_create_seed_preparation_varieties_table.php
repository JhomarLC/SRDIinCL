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
        Schema::create('seed_preparation_varieties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeds_preparation_id')
                ->constrained('seeds_preparations')
                ->onDelete('cascade');
            $table->foreignId('seed_variety_id')
                ->nullable()
                ->constrained('varieties')
                ->onDelete('cascade');
            $table->string('variety_name')->nullable();
            $table->enum('purchase_type', ['free', 'purchase'])->default('free');
            $table->integer('qty')->nullable();
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seed_preparation_varieties');
    }
};
