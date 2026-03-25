<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perizinan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pemohon');
            $table->string('email_pemohon');
            $table->string('phone_pemohon')->nullable();
            $table->string('jenis_izin')->default('lainnya'); // kegiatan, kerjasama, rekomendasi, lainnya
            $table->string('judul_permohonan');
            $table->text('deskripsi');
            $table->json('dokumen_pendukung')->nullable();
            $table->string('status')->default('pending'); // pending, review, approved, rejected
            $table->text('catatan_admin')->nullable();
            $table->date('tanggal_permohonan');
            $table->date('tanggal_proses')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};
