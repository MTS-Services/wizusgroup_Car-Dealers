<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Category;

return new class extends Migration
{
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
           $table->id();

            $table->bigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('parent_id')->nullable()->index();

            $table->string('name');
            $table->string('slug');

            $table->longText('description')->nullable();
            $table->string('image')->nullable();

            $table->boolean('status')->default(Category::STATUS_ACTIVE)->index();
            $table->boolean('is_featured')->default(Category::NOT_FEATURED)->index();

            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            // Constraints
            $table->unique(['parent_id', 'name']); // Avoid same name under same parent
            $table->unique(['parent_id', 'slug']); // Ensure slugs are unique under parent
            $table->foreign('parent_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Indexes for filtering/sorting
            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
