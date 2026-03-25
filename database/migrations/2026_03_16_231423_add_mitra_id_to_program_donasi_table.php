<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_donasi', function (Blueprint $table) {
            $table->foreignId('mitra_id')->nullable()->after('id')->constrained('mitra')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('program_donasi', function (Blueprint $table) {
            $table->dropForeign(['mitra_id']);
            $table->dropColumn('mitra_id');
        });
    }
};
