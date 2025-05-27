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
        Schema::create('region_shipping_timelines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('region_id')->unique()->index();
            $table->integer('min_days');
            $table->integer('max_days');
            $table->string('ports');
            $table->text('description')->nullable();



            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('region_shipping_timelines');
    }
};
