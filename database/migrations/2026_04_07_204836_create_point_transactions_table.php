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
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loyalty_account_id');
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->string('type');
            $table->integer('points');
            $table->text('description')->nullable();
            $table->date('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('loyalty_account_id')
                ->references('id')
                ->on('loyalty_accounts')
                ->cascadeOnDelete();

            $table->foreign('sale_id')
                ->references('id')
                ->on('sales')
                ->nullOnDelete();

            $table->index(['loyalty_account_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_transactions');
    }
};
