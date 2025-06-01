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
        Schema::create('harvest_manual_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('harvest_manual_detail_id')->constrained()->onDelete('cascade');
            $table->string('activity'); // ex. "Labor: Threshing", "Twine needle, pc"
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
        Schema::dropIfExists('harvest_manual_items');
    }
};
