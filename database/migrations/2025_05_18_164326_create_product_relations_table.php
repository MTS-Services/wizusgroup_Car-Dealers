<?php

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
        Schema::create('product_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('tax_class_id')->nullable();
            $table->unsignedBigInteger('tax_rate_id')->nullable();

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('sub_child_category_id')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sub_category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sub_child_category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tax_class_id')->references('id')->on('tax_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('cascade')->onUpdate('cascade');


            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->unique(['product_id','company_id','brand_id', 'model_id','category_id','sub_category_id','sub_child_category_id'], 'uq_product_relation_composite');


            // Indexes
            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_relations');
    }
};
