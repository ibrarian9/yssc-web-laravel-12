<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_legal', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->string('jenis')->default('lainnya'); // akta, sk, npwp, siup, lainnya
            $table->string('file_path')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_legal');
    }
};
