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
        Schema::create('labor_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_detail_id')->constrained()->onDelete('cascade');
            $table->decimal('bags', 12, 2);
            $table->decimal('avg_bag_weight', 12, 2);
            $table->decimal('price_per_kilo', 12, 2);
            $table->decimal('share_percent', 5, 2);
            $table->decimal('computed_total', 12, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_shares');
    }
};
