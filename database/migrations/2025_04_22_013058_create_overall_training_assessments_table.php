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
        Schema::create('overall_training_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_evaluation_id')->constrained()->onDelete('cascade');
            $table->enum('goal_achievement', ['Not Achieved', 'Partially Achieved', 'Achieved']);
            $table->enum('overall_quality', ['Excellent', 'Very Good', 'Good', 'Fair', 'Poor']);
            $table->longText('additional_feedback_or_suggestions')->nullable();
            $table->boolean('recommend_training');
            $table->longText('recommendation_reason')->nullable();
            $table->text('preferred_future_trainings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overall_training_assessments');
    }
};
