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
        Schema::table('village_services', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->string('icon', 50)->nullable()->after('slug');
            $table->text('process_steps')->nullable()->after('description');
            $table->string('estimated_time', 100)->nullable()->after('process_steps');
            $table->string('cost', 255)->nullable()->after('estimated_time');
            $table->boolean('is_active')->default(true)->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_services', function (Blueprint $table) {
            $table->dropColumn(['slug', 'icon', 'process_steps', 'estimated_time', 'cost', 'is_active']);
        });
    }
};
