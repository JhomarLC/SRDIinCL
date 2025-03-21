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
        Schema::create('training_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'participant_id')->constrained()->onDelete('cascade');
            $table->integer('pre_test_score');
            $table->integer('post_test_score');
            $table->integer('total_test_items');
            $table->decimal('knowledge_gain');
            $table->string('certificate_type');
            $table->string('certificate_number');
            $table->decimal('training_evaluation_score');
            $table->decimal('trainer_rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_results');
    }
};
