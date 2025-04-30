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
        Schema::create('course_management_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_evaluation_id')->constrained()->onDelete('cascade');
            $table->integer('coordination_score');
            $table->integer('time_management_score');
            $table->integer('speaker_quality_score');
            $table->integer('facilitators_score');
            $table->integer('support_staff_score');
            $table->integer('materials_score');
            $table->integer('facility_score');
            $table->integer('accommodation_score');
            $table->integer('food_quality_score');
            $table->integer('transportation_score');
            $table->integer('overall_management_score');

            $table->longText('coordination_comment')->nullable();
            $table->longText('time_management_comment')->nullable();
            $table->longText('speaker_quality_comment')->nullable();
            $table->longText('facilitators_comment')->nullable();
            $table->longText('support_staff_comment')->nullable();
            $table->longText('materials_comment')->nullable();
            $table->longText('facility_comment')->nullable();
            $table->longText('accommodation_comment')->nullable();
            $table->longText('food_quality_comment')->nullable();
            $table->longText('transportation_comment')->nullable();
            $table->longText('overall_management_comment')->nullable();

            $table->longText('low_score_comment_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_management_evaluations');
    }
};
