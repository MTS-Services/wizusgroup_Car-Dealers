<?php

use App\Models\TaxRate;
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
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('tax_class_id')->index();
            $table->unsignedBigInteger('country_id')->index();
            $table->unsignedBigInteger('state_id')->nullable()->index();
            $table->unsignedBigInteger('city_id')->nullable()->index();
            $table->boolean('status')->default(TaxRate::STATUS_ACTIVE)->index()->comment(TaxRate::STATUS_ACTIVE . ': Active, ' . TaxRate::STATUS_DEACTIVE . ': Inactive');
            $table->decimal('rate', 8, 2);
            $table->string('name');
            $table->tinyInteger('priority')->default(0)->index()->comment(TaxRate::PRIORITY_URGENT . ': Urgent, ' . TaxRate::PRIORITY_HIGH . ': High, ' . TaxRate::PRIORITY_NORMAL . ': Normal, ' . TaxRate::PRIORITY_LOW . ': Low');
            $table->boolean('compound')->default(TaxRate::COMPOUND_TRUE)->index()->comment(TaxRate::COMPOUND_TRUE . ': True, ' . TaxRate::COMPOUND_FALSE . ': False');
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->foreign('tax_class_id')->references('id')->on('tax_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('tax_rates');
    }
};
