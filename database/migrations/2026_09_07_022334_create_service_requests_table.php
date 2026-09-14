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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('village_id')->constrained('villages')->cascadeOnDelete();
            $table->foreignId('village_service_id')->constrained('village_services')->cascadeOnDelete();
            $table->enum('status', ['pending', 'processed', 'completed', 'rejected'])->default('pending');
            $table->string('attachment_path')->nullable();
            $table->text('notes')->nullable();
            $table->text('response_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
