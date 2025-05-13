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
        Schema::table('temp_files', function (Blueprint $table) {
            $table->unsignedBigInteger('from_id')->nullable();
            $table->string('from_type')->nullable();

            $table->index(['from_id', 'from_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_files', function (Blueprint $table) {
            $table->dropIndex(['from_id', 'from_type']);
            $table->dropColumn(['from_id', 'from_type']);
        });
    }
};
