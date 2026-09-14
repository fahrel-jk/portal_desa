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
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->integer('tahun_anggaran');
            $table->enum('kategori', ['pendapatan', 'belanja', 'pembiayaan']);
            $table->string('bidang')->nullable();
            $table->string('uraian');
            $table->decimal('jumlah_anggaran', 15, 2);
            $table->decimal('jumlah_realisasi', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['village_id', 'tahun_anggaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggarans');
    }
};
