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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained('categories')->onDelete('cascade')->nullable();
            $table->foreignId('sub_child_category_id')->constrained('categories')->onDelete('cascade')->nullable();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

             $table->unique(['category_id', 'sub_category_id', 'sub_child_category_id','product_id'], 'uq_product_category_composite'); // prevent duplicate rows


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
        Schema::dropIfExists('product_categories');
    }
};
