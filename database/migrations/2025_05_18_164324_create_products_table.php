<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;

return new class extends Migration
{
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Sorting & basic info
            $table->bigInteger('sort_order')->default(0)->index();
            $table->string('name');
            $table->string('slug')->unique(); // Slugs should be unique for SEO & URL routing
            $table->string('sku')->unique(); // SKU should be unique across products


            // Basic Information
            $table->string('stock_no')->unique();
            $table->string('grade')->nullable();
            $table->string('body')->nullable();
            $table->string('first_registration')->nullable();
            $table->string('type')->nullable();
            $table->string('displacement')->nullable();
            $table->string('specification_no')->nullable();
            $table->string('classification_no')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('capacity')->nullable();
            $table->longText('remarks')->nullable();


            // Descriptions
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable(); // Changed to longText for rich product descriptions

            // Pricing
            $table->decimal('price', 10, 2)->index(); // price including tax or base?
            $table->decimal('cost_price', 10, 2)->index(); // base cost
            $table->decimal('sale_price', 10, 2)->index(); // promotional price if any

            // Inventory
            $table->unsignedInteger('quantity')->default(0); // non-negative
            $table->boolean('allow_backorder')->default(false)->index(); // indexed for faster backorder queries

            // Flags
            $table->tinyInteger('status')->default(Product::STATUS_ACTIVE)->index();
            $table->boolean('is_featured')->default(Product::NOT_FEATURED)->index();
            $table->boolean('is_dropshipping')->default(Product::NOTALLOW_DROPSHIPPING)->index();

            // Dropshipping supplier relation
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null')->onUpdate('cascade');

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();

            // Timestamps & soft deletes
            $table->timestamps();
            $table->softDeletes();

            // Admin audit columns
            $this->addAdminAuditColumns($table);

            // Common indexes
            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
