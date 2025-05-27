<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;

return new class extends Migration {
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('container_reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('container_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->string('product_name');
            $table->string('length_cm')->index();
            $table->string('width_cm')->index();
            $table->string('height_cm')->index();
            $table->string('weight_kg')->nullable();
            $table->string('status')->index()->comment(ContainerReservation::STATUS_PENDING);
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('container_reservations');
    }
};
