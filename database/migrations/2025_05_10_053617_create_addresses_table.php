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
            $table->bigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('profile_id');
            $table->string('profile_type');
            $table->tinyInteger('type')->default(Address::TYPE_OTHER)->comment(Address::TYPE_PERSONAL . ': Personal, ' . Address::TYPE_BILLING . ': Billing, ' . Address::TYPE_SHIPPING . ': Shipping', Address::TYPE_OTHER . ': Other');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('operation_area_id')->nullable();
            $table->unsignedBigInteger('operation_sub_area_id')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('postal_code');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('is_default')->default(Address::DEFAULT)->comment(Address::DEFAULT . ': Default, ' . Address::NOT_DEFAULT . ': Not Default');
            $table->boolean('status')->default(Address::STATUS_ACTIVE)->comment(Address::STATUS_ACTIVE . ': Active, ' . Address::STATUS_DEACTIVE . ': Inactive');
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
            $table->index('sort_order');
            $table->index('profile_id');
            $table->index('profile_type');
            $table->index('type');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
            $table->index('operation_area_id');
            $table->index('operation_sub_area_id');
            $table->index('postal_code');
            $table->index('is_default');
            $table->index('status');

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
