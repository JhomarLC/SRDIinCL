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
            $table->foreignId('farming_data_id')
                ->constrained('farming_data') // <-- explicitly state the correct table
                ->onDelete('cascade');
            $table->string('category'); // Land Preparation, etc.
            $table->string('method')->nullable(); // Manual, Mechanical (optional)
            $table->boolean('is_pakyaw')->comment('True if activity is a pakyaw/all-in contract.');
            $table->decimal('total_cost', 12, 2)->comment('Total cost if pakyaw, or sum of details otherwise');
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
