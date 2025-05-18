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
        Schema::create('farming_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_data_id')->constrained('farming_data')->onDelete('cascade');
            $table->string('category'); // e.g., Land Prep, Fertilizer App, Pest Management
            $table->string('method')->nullable();
            $table->boolean('is_pakyaw')->default(false);
            $table->decimal('total_cost', 12, 2)->nullable()->comment('Only filled when pakyaw');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farming_activities');
    }
};
