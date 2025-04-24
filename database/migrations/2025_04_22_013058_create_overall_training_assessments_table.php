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
            $table->enum('goal_achievement', ['Not Achieved', 'Partially Achieved', 'Achieve']);
            $table->enum('overall_quality', ['Very Good', 'Good', 'Fair', 'Poor']);
            $table->longText('additional_feedback_or_suggestions');
            $table->boolean('recommend_training');
            $table->longText('recommendation_reason');
            $table->text('preferred_future_trainings');
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
