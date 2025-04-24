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
        Schema::create('useful_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_content_evaluation_id')->constrained()->onDelete('cascade');
            $table->string('topic_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useful_topics');
    }
};
