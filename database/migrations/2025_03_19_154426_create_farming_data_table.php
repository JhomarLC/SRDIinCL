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
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->enum('season', ['Wet Season', 'Dry Season']);
            $table->string('year_training_conducted');
            $table->decimal('farm_size_hectares', 8, 2);
            $table->string('method_crop_establishment')->nullable(); // e.g., DWSR, TPR
            $table->decimal('yield_tons_per_ha', 8, 2)->nullable();
            $table->decimal('est_moisture_content_percent', 5, 2)->nullable(); // e.g., 18 or 25
            $table->integer('number_of_bags')->nullable();
            $table->decimal('avg_weight_per_bag', 8, 2)->nullable();
            $table->decimal('price_per_kg_fresh', 8, 2)->nullable();
            $table->decimal('price_per_kg_dry', 8, 2)->nullable();
            $table->decimal('drying_cost_per_bag', 8, 2)->nullable();
            $table->decimal('total_yield_caban', 8, 2);
            $table->decimal('weight_per_caban_kg', 8, 2);
            $table->decimal('price_per_kg', 8, 2);
            $table->decimal('total_income', 12, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->decimal('other_crops', 8, 2)->nullable();
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
