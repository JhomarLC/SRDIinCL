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
        Schema::create('farming_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'participant_id')->constrained()->onDelete('cascade');
            $table->enum('season', [
                'Wet Season',
                'Dry Season'
            ]);
            $table->string('year');
            $table->decimal('farm_size_hectares');
            $table->decimal('total_yield_caban');
            $table->decimal('weight_per_caban_kg');
            $table->decimal('price_per_kg');
            $table->decimal('total_income');
            $table->decimal('total_cost');
            $table->decimal('other_crops');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farming_data');
    }
};
