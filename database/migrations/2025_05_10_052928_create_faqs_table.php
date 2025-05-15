<?php

use App\Models\Faq;
use App\Http\Traits\AuditColumnsTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    use SoftDeletes, AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('question')->index();
            $table->longText('answer');
            $table->tinyInteger('type')->default(Faq::TYPE_GENERAL)->index()->comment(Faq::TYPE_GENERAL . ': General, ' . Faq::TYPE_PRIVACY . ': Privacy, ' . Faq::TYPE_TERMS . ': Terms' . Faq::TYPE_CONTACT . ': Contact' . Faq::TYPE_ABOUT . ': About' . Faq::TYPE_PRODUCT . ': Product');
            $table->boolean('status')->default(Faq::STATUS_ACTIVE)->index();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

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
        Schema::dropIfExists('faqs');
    }
};
