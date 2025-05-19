<?php

use App\Models\Company;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();

            $table->string('name')->unique();
            $table->string('slug')->unique();

            $table->string('image')->nullable();
            $table->string('website')->nullable();

            $table->boolean('status')->default(Company::STATUS_ACTIVE)->index();
            $table->boolean('is_featured')->default(Company::NOT_FEATURED)->index();

            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
