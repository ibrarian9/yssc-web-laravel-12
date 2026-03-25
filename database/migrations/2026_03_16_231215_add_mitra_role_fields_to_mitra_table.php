<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('dokumen_legalitas');
            $table->text('deskripsi')->nullable()->after('logo');
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['logo', 'deskripsi', 'user_id']);
        });
    }
};
