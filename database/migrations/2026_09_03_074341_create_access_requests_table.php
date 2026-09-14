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
        Schema::create('access_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nik');
            $table->string('jabatan_keperluan');
            $table->string('no_hp');
            $table->string('email');
            $table->foreignId('desa_id')->constrained('villages')->cascadeOnDelete();
            $table->string('dokumen_pendukung');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('alasan_reject')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_requests');
    }
};
