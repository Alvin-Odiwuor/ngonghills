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
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loyalty_account_id');
            $table->unsignedBigInteger('reward_id');
            $table->unsignedInteger('points_used');
            $table->string('status')->default('pending');
            $table->dateTime('redeemed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('loyalty_account_id')
                ->references('id')
                ->on('loyalty_accounts')
                ->cascadeOnDelete();

            $table->foreign('reward_id')
                ->references('id')
                ->on('rewards')
                ->restrictOnDelete();

            $table->index(['loyalty_account_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemptions');
    }
};
