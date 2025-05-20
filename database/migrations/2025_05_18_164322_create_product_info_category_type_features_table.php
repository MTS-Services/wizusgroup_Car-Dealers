<?php

use App\Models\ProductInfoCategoryTypeFeature;
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
        Schema::create('product_info_category_type_features', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('product_info_cat_id');
            $table->unsignedBigInteger('product_info_cat_type_id');

            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('status')->default(ProductInfoCategoryTypeFeature::STATUS_ACTIVE)->index();
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->foreign('product_info_cat_type_id', 'fk_cat_type_id')
                ->references('id')
                ->on('product_info_category_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('product_info_cat_id', 'fk_cat_id')
                ->references('id')
                ->on('product_info_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['product_info_cat_type_id', 'name'], 'type_feature_unique');
            $table->index('product_info_cat_id', 'idx_cat_id');
            $table->index('product_info_cat_type_id', 'idx_cat_type_id');




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
        Schema::dropIfExists('product_info_category_type_features');
    }
};
