<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            $table->string('npwp')->nullable()->change();
            $table->string('dokumen_npwp')->nullable()->change();
            $table->string('dokumen_legalitas')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            $table->string('npwp')->nullable(false)->change();
            $table->string('dokumen_npwp')->nullable(false)->change();
            $table->string('dokumen_legalitas')->nullable(false)->change();
        });
    }
};
