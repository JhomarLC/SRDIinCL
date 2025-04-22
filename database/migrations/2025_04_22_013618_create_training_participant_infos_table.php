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
        Schema::create('training_participant_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_evaluation_id')->constrained()->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('age_group');
            $table->enum('primary_sector', [
                'Farmer/Seed Grower',
                'Extension Worker',
                'Researcher',
                'Educator',
                'Student',
                'Policy Maker',
                'Media',
                'Industry Player',
                'Others'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_participant_infos');
    }
};
