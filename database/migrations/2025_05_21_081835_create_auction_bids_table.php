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
        Schema::create('auction_bids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('auction_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->decimal('bid_amount', 15, 2)->min(0)->default(0)->index();
            $table->boolean('is_winning')->default(0)->index();
            $table->boolean('is_buy_now')->default(0)->index();

            $table->string('ip_address')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('auction_bids');
    }
};
