<?php

use App\Models\TaxClass;
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
        Schema::create('tax_classes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0)->index();
            $table->string('name')->unique();
            $table->boolean('status')->default(TaxClass::STATUS_ACTIVE)->index();
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
        Schema::dropIfExists('tax_classes');
    }
};
