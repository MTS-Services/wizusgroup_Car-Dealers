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
        Schema::create('product_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_info_cat_id');
            $table->unsignedBigInteger('product_info_cat_type_id')->nullable();
            $table->unsignedBigInteger('product_info_cat_type_feature_id')->nullable();
            $table->longText('description')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('product_info_cat_id', 'fki_cat_id')
                ->references('id')
                ->on('product_info_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
             $table->foreign('product_info_cat_type_id', 'fki_cat_t_id')
                ->references('id')
                ->on('product_info_category_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

             $table->foreign('product_info_cat_type_feature_id', 'fki_cat_t_f_id')
                ->references('id')
                ->on('product_info_category_type_features')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('product_information');
    }
};
