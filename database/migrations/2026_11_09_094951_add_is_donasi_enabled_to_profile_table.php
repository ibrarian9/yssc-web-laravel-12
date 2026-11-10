<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->boolean('is_donasi_enabled')->default(true)->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn('is_donasi_enabled');
        });
    }
};
