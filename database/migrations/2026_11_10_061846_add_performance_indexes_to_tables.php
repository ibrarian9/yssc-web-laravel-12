<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->index(['status', 'tipe', 'created_at'], 'berita_status_tipe_created_idx');
        });

        Schema::table('donasi', function (Blueprint $table) {
            $table->index(['status_pembayaran', 'created_at'], 'donasi_status_created_idx');
            $table->index('email_donatur', 'donasi_email_idx');
        });

        Schema::table('program_donasi', function (Blueprint $table) {
            $table->index(['status', 'urutan'], 'program_donasi_status_urutan_idx');
        });

        Schema::table('perizinan', function (Blueprint $table) {
            $table->index('status', 'perizinan_status_idx');
        });

        Schema::table('mitra', function (Blueprint $table) {
            $table->index('status', 'mitra_status_idx');
        });

        Schema::table('relawan', function (Blueprint $table) {
            $table->index('status', 'relawan_status_idx');
        });

        Schema::table('anggota_devisi', function (Blueprint $table) {
            $table->index(['is_active', 'urutan'], 'anggota_active_urutan_idx');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->index(['is_active', 'urutan'], 'sliders_active_urutan_idx');
        });
    }

    public function down(): void
    {
        Schema::table('berita', fn (Blueprint $t) => $t->dropIndex('berita_status_tipe_created_idx'));
        Schema::table('donasi', function (Blueprint $t) {
            $t->dropIndex('donasi_status_created_idx');
            $t->dropIndex('donasi_email_idx');
        });
        Schema::table('program_donasi', fn (Blueprint $t) => $t->dropIndex('program_donasi_status_urutan_idx'));
        Schema::table('perizinan', fn (Blueprint $t) => $t->dropIndex('perizinan_status_idx'));
        Schema::table('mitra', fn (Blueprint $t) => $t->dropIndex('mitra_status_idx'));
        Schema::table('relawan', fn (Blueprint $t) => $t->dropIndex('relawan_status_idx'));
        Schema::table('anggota_devisi', fn (Blueprint $t) => $t->dropIndex('anggota_active_urutan_idx'));
        Schema::table('sliders', fn (Blueprint $t) => $t->dropIndex('sliders_active_urutan_idx'));
    }
};
