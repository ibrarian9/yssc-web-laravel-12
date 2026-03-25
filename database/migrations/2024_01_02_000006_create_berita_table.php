<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->string('excerpt', 300)->nullable();
            $table->string('thumbnail')->nullable();
            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tipe')->default('berita'); // berita, kegiatan
            $table->string('status')->default('draft'); // draft, published, archived
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('lokasi')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
