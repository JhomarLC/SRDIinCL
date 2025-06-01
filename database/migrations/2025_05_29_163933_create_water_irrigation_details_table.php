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
        Schema::create('water_irrigation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'water_irrigation_id')->constrained()->onDelete('cascade');
            $table->string('activity'); // Fee, Fuel, Labor, Meals
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
        Schema::dropIfExists('water_irrigation_details');
    }
};
