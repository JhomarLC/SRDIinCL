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
            Schema::create('harvest_mechanical_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('harvest_management_id')->constrained('harvest_management')->onDelete('cascade');
                $table->integer('bags')->nullable();
                $table->decimal('avg_bag_weight', 10, 2)->nullable();
                $table->decimal('price_per_kg', 10, 2)->nullable();
                $table->decimal('total_cost', 10, 2)->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('harvest_mechanical_details');
        }
    };
