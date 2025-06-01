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
        Schema::create('pesticide_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farming_data_id')->constrained('farming_data')->onDelete('cascade');
            $table->string('label'); // e.g. "1st Application"
            $table->string('others')->nullable(); // for "others" field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesticide_applications');
    }
};
