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
        Schema::create('seeds_preparation_particulars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeds_preparation_id')->constrained()->onDelete('cascade');
            $table->string('activity'); // e.g., Soaking, Incubation, Sowing
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
        Schema::dropIfExists('seeds_preparation_particulars');
    }
};
