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
        Schema::create('pengajuan_layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tracking')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('village_services')->cascadeOnDelete();
            $table->foreignId('desa_id')->constrained('villages')->cascadeOnDelete();
            $table->json('data_pemohon');
            $table->enum('status', ['diajukan', 'diproses', 'selesai', 'ditolak'])->default('diajukan');
            $table->text('alasan_ditolak')->nullable();
            $table->string('file_surat_hasil')->nullable();
            $table->text('catatan_operator')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_layanans');
    }
};
