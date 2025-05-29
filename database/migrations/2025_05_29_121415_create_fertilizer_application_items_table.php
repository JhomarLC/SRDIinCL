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
        Schema::create('fertilizer_application_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fertilizer_application_id');
            $table->foreign('fertilizer_application_id', 'fk_fa_fertilizers_m_fert_id')
                ->references('id')
                ->on('fertilizer_applications')
                ->onDelete('cascade');

            $table->string('fertilizer_name')->nullable();
            $table->string('purchase_type')->default('free');
            $table->integer('qty')->nullable();
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fertilizer_application_items');
    }
};
