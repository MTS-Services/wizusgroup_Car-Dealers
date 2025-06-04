<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Order;
use App\Models\OrderItem;

return new class extends Migration {
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->boolean('is_dropshipping')->default(OrderItem::NOT_DROPSHIPPING)->comment(OrderItem::NOT_DROPSHIPPING . ' = no, ' . OrderItem::DROPSHIPPING . ' = yes')->index();
            $table->tinyInteger('status')->default(OrderItem::STATUS_PENDING)->index();
            $table->tinyInteger('dropshipping_status')->nullable()->index();


            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);


            // Relationships
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

            // Indexes
            $table->index('created_at'); // Index for soft deletes
            $table->index('updated_at'); // Index for soft deletes
            $table->index('deleted_at'); // Index for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
