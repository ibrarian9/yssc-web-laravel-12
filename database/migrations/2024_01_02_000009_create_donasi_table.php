<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_donasi_id')->constrained('program_donasi')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_donatur');
            $table->string('email_donatur');
            $table->string('phone')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->text('pesan')->nullable();
            $table->boolean('is_anonim')->default(false);
            $table->string('metode_pembayaran')->nullable();
            $table->string('status_pembayaran')->default('pending'); // pending, success, failed, expired
            $table->string('kode_unik')->unique();
            $table->string('bukti_transfer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
