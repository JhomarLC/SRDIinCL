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
        Schema::create('crop_establishments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_data_id')->constrained('farming_data')->onDelete('cascade');
            $table->enum('method', ['DWSR', 'TPR']);
            $table->string('establishment_type')->nullable(); // Manual, Mechanical, Drumseeder, etc.
            $table->boolean('is_pakyaw')->default(false);
            $table->decimal('package_total_cost', 10, 2)->nullable(); // if pakyaw is true
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_establishments');
    }
};
