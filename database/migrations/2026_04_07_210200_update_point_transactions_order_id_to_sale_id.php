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
        if (!Schema::hasTable('point_transactions')) {
            return;
        }

        if (Schema::hasColumn('point_transactions', 'order_id')) {
            Schema::table('point_transactions', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
                $table->dropColumn('order_id');
            });
        }

        if (!Schema::hasColumn('point_transactions', 'sale_id')) {
            Schema::table('point_transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('sale_id')->nullable()->after('loyalty_account_id');
                $table->foreign('sale_id')->references('id')->on('sales')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('point_transactions')) {
            return;
        }

        if (Schema::hasColumn('point_transactions', 'sale_id')) {
            Schema::table('point_transactions', function (Blueprint $table) {
                $table->dropForeign(['sale_id']);
                $table->dropColumn('sale_id');
            });
        }

        if (!Schema::hasColumn('point_transactions', 'order_id')) {
            Schema::table('point_transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('order_id')->nullable()->after('loyalty_account_id');
                $table->foreign('order_id')->references('id')->on('purchases')->nullOnDelete();
            });
        }
    }
};
