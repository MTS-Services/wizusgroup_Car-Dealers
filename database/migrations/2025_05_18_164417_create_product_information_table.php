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
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade')->index();
            $table->foreignId('product_info_cat_id')->constrained('product_info_categories')->onDelete('cascade')->onUpdate('cascade')->index();
            $table->foreignId('product_info_cat_type_id')->constrained('product_info_cat_types')->onDelete('cascade')->onUpdate('cascade')->index()->nullable();
            $table->foreignId('product_info_cat_type_feature_id')->constrained('product_info_cat_type_features')->onDelete('cascade')->onUpdate('cascade')->index()->nullable();
            $table->longText('remarks');
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);


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
