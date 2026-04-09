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
        Schema::create('production_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('quantity_produced', 15, 3);
            $table->date('production_date');
            $table->string('batch_number')->unique();
            $table->text('notes')->nullable();
            $table->foreignId('produced_by')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['planned', 'in-progress', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();

            $table->index(['recipe_id', 'product_id', 'status']);
            $table->index('production_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_runs');
    }
};
