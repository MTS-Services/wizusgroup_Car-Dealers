<?php

use App\Models\ProductImage;
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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade')->index(); // Index for faster lookups->default(0)->index();
            $table->string('image');
            $table->boolean('status')->default(ProductImage::STATUS_ACTIVE)->comment(ProductImage::STATUS_ACTIVE . ': Active, ' . ProductImage::STATUS_DEACTIVE . ': Deactive');
            $table->string('alt')->nullable();
            $table->boolean('is_primary')->nullable()->default(ProductImage::NOT_PRIMARY)->comment(ProductImage::NOT_PRIMARY . ': Not Primary, ' . ProductImage::IS_PRIMARY . ': Primary');
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
        Schema::dropIfExists('product_images');
    }
};
