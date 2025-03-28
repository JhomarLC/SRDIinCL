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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('nickname')->nullable();
            $table->string('phone_number');
            $table->date('birth_date');
            $table->string('age_group');
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
            $table->string('gender');
            $table->string('civil_status');
            $table->string('religion');
            $table->boolean('is_indigenous');
            $table->string('tribe_name')->nullable();
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('zip_code');
            $table->string('house_number_sitio_purok')->nullable();
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
            $table->integer('years_in_farming');
            $table->string('farmer_association');
            $table->enum('education_level', [
                'Elementary',
                'High School',
                'Vocational',
                'College Degree',
                'Master’s Degree',
                'Doctorate Degree',
                'Undergraduate',
                'Others'
            ]);
            $table->enum('farm_role', [
                'Farm Owner',
                'Relative of Farm Owner'
            ]);
            $table->string('rsbsa_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
