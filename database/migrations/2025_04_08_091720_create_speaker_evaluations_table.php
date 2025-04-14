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
        Schema::create('speaker_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speaker_topic_id')->constrained()->onDelete('cascade');
            $table->integer('knowledge_score');
            $table->integer('teaching_method_score');
            $table->integer('audiovisual_score');
            $table->integer('clarity_score');
            $table->integer('question_handling_score');
            $table->integer('audience_connection_score');
            $table->integer('content_relevance_score');
            $table->integer('goal_achievement_score');
            $table->longText('knowledge_score_comment')->nullable();
            $table->longText('teaching_method_comment')->nullable();
            $table->longText('audiovisual_comment')->nullable();
            $table->longText('clarity_comment')->nullable();
            $table->longText('question_handling_comment')->nullable();
            $table->longText('audience_connection_comment')->nullable();
            $table->longText('content_relevance_comment')->nullable();
            $table->longText('goal_achievement_comment')->nullable();
            $table->longText('additional_feedback')->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaker_evaluations');
    }
};
