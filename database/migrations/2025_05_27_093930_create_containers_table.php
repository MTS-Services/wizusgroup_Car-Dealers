<?php

use App\Models\Container;
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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->dateTime('deadline')->index();
            $table->string('length_m')->index();
            $table->string('width_m')->index();
            $table->string('height_m')->index();
            $table->string('max_weight_kg')->index();
            $table->string('base_cost')->index();
            $table->string('per_kg_cost')->index();
            $table->string('per_cbm_cost')->index();

            $table->unsignedBigInteger('shipping_port')->index();
            $table->unsignedBigInteger('destination_port')->index();
            $table->boolean('status')->index()->default(Container::STATUS_PENDING);
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->foreign('shipping_port')->references('id')->on('shipping_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('destination_port')->references('id')->on('shipping_locations')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('containers');
    }
};
