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
        Schema::create('harvest_manual_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('harvest_management_id')->constrained('harvest_management')->onDelete('cascade');
            $table->boolean('is_package')->default(false);
            $table->decimal('package_total_cost', 10, 2)->nullable(); // Nullable if not package
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvest_manual_details');
    }
};
