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
        Schema::create('notable_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('overall_training_assessment_id')->constrained()->onDelete('cascade');
            $table->string('employee_name')->nullable();
            $table->longText('employee_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notable_employees');
    }
};
