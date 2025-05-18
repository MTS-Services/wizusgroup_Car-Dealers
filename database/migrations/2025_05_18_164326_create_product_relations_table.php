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

            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('brand_id')->constrained('brands')->onUpdate('cascade')->onDelete('cascade')->nullable();

            $table->foreignId('model_id')->constrained('brands')->onUpdate('cascade')->onDelete('cascade')->nullable();

            $table->foreignId('tax_class_id')->constrained('tax_classes')->onUpdate('cascade')->onDelete('cascade')->nullable();

            $table->foreignId('tax_rate_id')->constrained('tax_rates')->onUpdate('cascade')->onDelete('cascade')->nullable();


            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->unique(['product_id','brand_id', 'model_id'], 'uq_product_relation_composite');


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
