<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->tinyInteger('container_type')->nullable()->index()->nullable()->comment(Order::GROUP_SHIPPING . ': Group Shipping, ' . Order::FULL_CONTAINER . ': Full Container, ');

            $table->unsignedBigInteger('shipping_port')->index()->nullable();
            $table->unsignedBigInteger('destination_port')->index()->nullable();
            $table->boolean('container_request')->default(Order::CONTINER_REQUEST_FALSE)->index();

            $table->foreign('shipping_port')->references('id')->on('shipping_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('destination_port')->references('id')->on('shipping_locations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('container_type');

            $table->dropForeign(['shipping_port']);
            $table->dropForeign(['destination_port']);

            $table->dropColumn('shipping_port');
            $table->dropColumn('destination_port');
        });
    }
};
