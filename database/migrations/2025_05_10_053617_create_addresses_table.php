<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Address;

return new class extends Migration
{
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('profile_id')->index();
            $table->string('profile_type')->index();
            $table->tinyInteger('type')->default(Address::TYPE_OTHER)->index()->comment(Address::TYPE_PERSONAL . ': Personal, ' . Address::TYPE_BILLING . ': Billing, ' . Address::TYPE_SHIPPING . ': Shipping'. Address::TYPE_OTHER . ': Other');
            $table->string('name')->nullable();
            $table->string('phone')->nullable()->index();
            $table->unsignedBigInteger('country_id')->index();
            $table->unsignedBigInteger('state_id')->nullable()->index();
            $table->unsignedBigInteger('city_id')->index();
            $table->unsignedBigInteger('operation_area_id')->nullable()->index();
            $table->unsignedBigInteger('operation_sub_area_id')->nullable()->index();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('postal_code')->index();
            $table->string('latitude')->nullable()->index();
            $table->string('longitude')->nullable()->index();
            $table->boolean('is_default')->default(Address::NOT_DEFAULT)->index();
            $table->boolean('status')->default(Address::STATUS_ACTIVE)->index();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            // Relations
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('operation_area_id')->references('id')->on('operation_areas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('operation_sub_area_id')->references('id')->on('operation_sub_areas')->onDelete('cascade')->onUpdate('cascade');

            // Indexes
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
        Schema::dropIfExists('addresses');
    }
};
