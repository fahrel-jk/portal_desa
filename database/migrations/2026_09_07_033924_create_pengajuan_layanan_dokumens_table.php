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
        Schema::create('pengajuan_layanan_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_layanan_id')->constrained()->cascadeOnDelete();
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('tipe_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_layanan_dokumens');
    }
};
