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
        Schema::create('seed_bed_fertilization_particulars', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('seed_bed_fertilization_id');
            $table->foreign('seed_bed_fertilization_id', 'fk_sbf_fertilizers_fert_id')
                ->references('id')
                ->on('seed_bed_fertilizations')
                ->onDelete('cascade');

            $table->string('activity');
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
        Schema::dropIfExists('seed_bed_fertilization_particulars');
    }
};
