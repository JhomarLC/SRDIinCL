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
        Schema::create('profile_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aews_profile_id')->constrained()->onDelete('cascade'); // FK to profiles
            $table->foreignId('training_id')->constrained()->onDelete('cascade'); // FK to trainings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_trainings');
    }
};