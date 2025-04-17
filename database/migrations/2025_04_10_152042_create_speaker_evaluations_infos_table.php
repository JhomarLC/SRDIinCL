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
        Schema::create('speaker_evaluations_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speaker_evaluation_id')->constrained()->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('age_group');
            $table->string('gender');

            $table->boolean('is_pwd');
            $table->enum('disability_type', [
                'Visual Impairment',
                'Hearing Loss',
                'Orthopedic Disability',
                'Learning Disability',
                'Psychological Disability',
                'Chronic Illness',
                'Mental Disability'
                ])->nullable();

            $table->boolean('is_indigenous');
            $table->string('tribe_name')->nullable();

            $table->string('province_code');
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
        Schema::dropIfExists('speaker_evaluations_infos');
    }
};
