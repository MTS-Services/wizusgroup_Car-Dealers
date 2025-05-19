<?php

use App\Models\Model;
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
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('name')->index();
            $table->string('slug')->unique();

            $table->boolean('status')->default(Model::STATUS_ACTIVE)->index();
            $table->boolean('is_featured')->default(Model::NOT_FEATURED)->index();

            $table->string('image')->nullable();
            $table->longText('description')->nullable();

            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->unique(['brand_id', 'name']); // Prevent same model name under same brand

            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
