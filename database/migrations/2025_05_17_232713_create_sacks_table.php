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
        Schema::create('sacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_detail_id')->constrained()->onDelete('cascade');
            $table->string('type'); // ordinary, laminated, twine, thread
            $table->decimal('qty', 12, 2);
            $table->decimal('unit_cost', 12, 2);
            $table->decimal('total_cost', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sacks');
    }
};
