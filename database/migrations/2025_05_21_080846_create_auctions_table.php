<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Auction;

return new class extends Migration
{
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->decimal('start_price', 15, 2)->min(0)->index();
            $table->decimal('reserve_price', 15, 2)->min(0)->index();
            $table->decimal('buy_now_price', 15, 2)->min(0)->nullable()->index();
            $table->decimal('increment_amount', 15, 2)->min(0)->nullable()->index();
            $table->string('location');
            $table->date('start_date')->nullable()->index();
            $table->date('end_date')->nullable()->index();

            $table->tinyInteger('status')->default(Auction::STATUS_SCHEDULED)->index();
            $table->boolean('is_featured')->default(Auction::FEATURED_NO)->index();

            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('auctions');
    }
};
