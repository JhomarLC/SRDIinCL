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
        Schema::create('food_restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'participant_id')->constrained()->onDelete('cascade');
            $table->string('food_restriction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_restrictions');
    }
};
