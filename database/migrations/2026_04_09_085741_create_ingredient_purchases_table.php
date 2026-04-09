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
        Schema::create('ingredient_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained('ingredients')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->decimal('quantity', 15, 3);
            $table->decimal('unit_cost', 15, 4);
            $table->decimal('total_cost', 15, 4);
            $table->date('purchase_date');
            $table->string('invoice_number');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['ingredient_id', 'supplier_id']);
            $table->index('purchase_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_purchases');
    }
};
