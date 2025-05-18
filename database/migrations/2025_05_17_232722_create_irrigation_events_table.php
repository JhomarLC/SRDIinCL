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
        Schema::create('irrigation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_activity_id')->constrained()->onDelete('cascade');
            $table->integer('round_number');
            $table->enum('irrigation_type', ['NIA', 'Supplementary']);
            $table->boolean('is_pakyaw')->default(false);
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irrigation_events');
    }
};
