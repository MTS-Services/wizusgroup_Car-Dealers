<?php

use App\Models\Banner;
use App\Http\Traits\AuditColumnsTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->string('title');
            $table->string('subtitle');
            $table->string('image');
            $table->string('url');
            $table->boolean('status')->default(Banner::STATUS_ACTIVE)->comment(Banner::STATUS_ACTIVE . ': Active, ' . Banner::STATUS_DEACTIVE . ': Inactive');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            // Indexes
            $table->index('sort_order');
            $table->index('title');
            $table->index('subtitle');
            $table->index('status');
            $table->index('url');
            $table->index('start_date');
            $table->index('end_date');
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
        Schema::dropIfExists('banners');
    }
};
