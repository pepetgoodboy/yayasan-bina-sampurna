<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            $table->enum('jenjang', ['TK', 'SD'])->nullable()->after('nama');
            $table->enum('gender', ['L', 'P', 'ALL'])->default('ALL')->after('jenjang');
            $table->integer('kelas_min')->nullable()->after('gender');
            $table->integer('kelas_max')->nullable()->after('kelas_min');
            $table->integer('gelombang')->nullable()->after('kelas_max');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_pembayaran', function (Blueprint $table) {
            $table->dropColumn(['jenjang', 'gender', 'kelas_min', 'kelas_max', 'gelombang']);
        });
    }
};