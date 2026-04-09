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
        Schema::create('outlets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['restaurant', 'bar', 'spa', 'room_service', 'shop', 'events', 'other']);
            $table->string('location');
            $table->foreignId('manager_id')->constrained('users')->cascadeOnDelete();
            $table->string('phone_extension', 20)->nullable();
            $table->time('opening_time');
            $table->time('closing_time');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index('manager_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};
