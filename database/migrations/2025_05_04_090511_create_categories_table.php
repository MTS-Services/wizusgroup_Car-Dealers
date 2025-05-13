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
            $table->bigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(Category::STATUS_ACTIVE)->comment(Category::STATUS_DEACTIVE . ': Deactive, ' . Category::STATUS_ACTIVE . ': Active');
            $table->boolean('is_featured')->default(Category::NOT_FEATURED)->comment(Category::NOT_FEATURED . ': No, ' . Category::FEATURED . ': Yes');
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            // Foreign keys
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

            // Indexes
            $table->index('sort_order');
            $table->index('parent_id');
            $table->index('name');
            $table->index('slug');
            $table->index('status');
            $table->index('is_featured');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
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
