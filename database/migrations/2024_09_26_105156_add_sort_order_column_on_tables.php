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
        $tables = ['users', 'admins', 'permissions', 'roles'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->bigInteger('sort_order')->default(0);

                $table->index('sort_order');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['users', 'admins', 'permissions', 'roles'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropIndex(['sort_order']);
                $table->dropColumn('sort_order');
            });
        }
    }
};
