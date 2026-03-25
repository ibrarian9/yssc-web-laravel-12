<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('nama_organisasi');
            $table->string('tagline')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->text('sejarah')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('logo')->nullable();
            $table->string('foto_kantor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
