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
        Schema::create('speaker_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'speaker_id')->constrained()->onDelete('cascade');
            $table->string('topic_discussed');
            $table->string('province_code');
            $table->string('municipality_code');
            $table->string('barangay_code');
            $table->date('topic_date');
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaker_topics');
    }
};
