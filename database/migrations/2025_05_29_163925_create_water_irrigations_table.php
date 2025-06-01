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
        Schema::create('water_irrigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('water_management_id')->constrained('water_management')->onDelete('cascade');
            $table->string('label'); // e.g. "1st Irrigation"
            $table->enum('method', ['nia', 'supplementary'])->default('supplementary');
            $table->decimal('nia_total', 10, 2)->nullable(); // used if method == 'nia'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_irrigations');
    }
};
