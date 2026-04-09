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
        Schema::create('ingredient_stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained('ingredients')->cascadeOnDelete();
            $table->enum('adjustment_type', ['addition', 'deduction']);
            $table->decimal('quantity', 15, 3);
            $table->enum('reason', ['purchase', 'wastage', 'spoilage', 'correction', 'return']);
            $table->nullableMorphs('reference');
            $table->text('notes')->nullable();
            $table->foreignId('adjusted_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(
                ['ingredient_id', 'adjustment_type', 'reason'],
                'ing_stock_adj_ing_type_reason_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_stock_adjustments');
    }
};
