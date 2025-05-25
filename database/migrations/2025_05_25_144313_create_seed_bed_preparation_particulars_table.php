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
        Schema::create('seed_bed_preparation_particulars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seedbed_preparation_id')
                ->constrained('seed_bed_preparations')
                ->onDelete('cascade');
            $table->string('activity'); // Plowing, Harrowing, Seedbed Construction
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
        Schema::dropIfExists('seed_bed_preparation_particulars');
    }
};
