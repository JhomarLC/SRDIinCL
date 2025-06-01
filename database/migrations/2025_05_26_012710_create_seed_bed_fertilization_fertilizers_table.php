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
        Schema::create('seed_bed_fertilization_fertilizers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seed_bed_fertilizations_id');
            $table->foreign('seed_bed_fertilizations_id', 'fk_sbf_fertilizers_m_fert_id')
                ->references('id')
                ->on('seed_bed_fertilizations')
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
        Schema::table('seed_bed_fertilization_fertilizers', function (Blueprint $table) {
            $table->dropForeign('fk_sbf_fertilizers_m_fert_id');
        });

        Schema::dropIfExists('seed_bed_fertilization_fertilizers');
    }
};
