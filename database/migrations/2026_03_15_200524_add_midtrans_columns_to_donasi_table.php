<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->unique()->after('bukti_transfer');
            $table->string('midtrans_snap_token')->nullable()->after('midtrans_order_id');
            $table->string('midtrans_payment_type')->nullable()->after('midtrans_snap_token');
            $table->timestamp('paid_at')->nullable()->after('midtrans_payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropColumn(['midtrans_order_id', 'midtrans_snap_token', 'midtrans_payment_type', 'paid_at']);
        });
    }
};
