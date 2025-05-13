<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\City;

return new class extends Migration
{
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string("name")->unique();
            $table->string("slug")->unique();
            $table->longText("description")->nullable();
            $table->boolean('status')->default(City::STATUS_ACTIVE)->comment(City::STATUS_ACTIVE . ': Active, ' . City::STATUS_DEACTIVE . ': Inactive');
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');

               // Indexes
               $table->index('sort_order');
               $table->index('country_id');
               $table->index('state_id');
               $table->index('name');
               $table->index('slug');
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
        Schema::dropIfExists('cities');
    }
};
