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
        Schema::create('aews_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->foreignId('employment_type_id')->constrained()->onDelete('cascade');
            $table->string('contact_number');
            $table->date('start_date'); // When employee started
            $table->date('end_date')->nullable(); // If they resign, retire, or transfer
            $table->enum('job_status', ['new', 'old', 'resigned', 'retired', 'transferred'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aews_profiles');
    }
};