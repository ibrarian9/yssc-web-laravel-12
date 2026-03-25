<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_mitra'); // perusahaan, organisasi, perorangan, lembaga
            $table->string('nama_perusahaan');
            $table->string('email')->unique();
            $table->string('telepon');
            $table->string('npwp');
            $table->string('dokumen_npwp'); // file path
            $table->string('dokumen_legalitas'); // file path
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('catatan_admin')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
