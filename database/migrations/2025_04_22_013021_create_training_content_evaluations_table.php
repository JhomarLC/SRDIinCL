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

            $table->longText('objective_comment')->nullable();
            $table->longText('relevance_comment')->nullable();
            $table->longText('content_completeness_comment')->nullable();
            $table->longText('lecture_hands_on_comment')->nullable();
            $table->longText('sequence_comment')->nullable();
            $table->longText('duration_comment')->nullable();
            $table->longText('assessment_method_comment')->nullable();

            $table->longText('low_score_comment_1')->nullable();

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
