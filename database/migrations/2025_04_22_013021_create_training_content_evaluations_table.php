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
        Schema::create('training_content_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_evaluation_id')->constrained()->onDelete('cascade');
            $table->integer('objective_score');
            $table->integer('relevance_score');
            $table->integer('content_completeness_score');
            $table->integer('lecture_hands_on_score');
            $table->integer('sequence_score');
            $table->integer('duration_score');
            $table->integer('assessment_method_score');

            $table->longText('low_score_comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_content_evaluations');
    }
};
