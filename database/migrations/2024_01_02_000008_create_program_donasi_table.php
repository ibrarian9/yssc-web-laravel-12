<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_donasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('deskripsi');
            $table->string('thumbnail')->nullable();
            $table->decimal('target_nominal', 15, 2)->default(0);
            $table->decimal('terkumpul_nominal', 15, 2)->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('status')->default('draft'); // aktif, selesai, draft
            $table->boolean('is_mendesak')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_donasi');
    }
};
