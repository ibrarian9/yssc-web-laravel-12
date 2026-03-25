<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_devisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divisi_id')->constrained('divisi')->cascadeOnDelete();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->text('bio')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('email')->nullable();
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_devisi');
    }
};
