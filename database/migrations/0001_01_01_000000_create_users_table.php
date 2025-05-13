<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique()->min(5)->max(20)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(User::STATUS_ACTIVE)->comment(User::STATUS_ACTIVE . ': Active, ' . User::STATUS_DEACTIVE . ': Inactive');
            $table->tinyInteger('is_verify')->default(User::UNVERIFIED)->comment(User::UNVERIFIED . ': Unverified, ' . User::VERIFIED . ': Verified');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);


            // Add the otp_send_at column (if it doesn't exist already)
            $table->timestamp('otp_send_at')->nullable(); // Add this line

            // Indexes
            $table->index('first_name'); // Index for first name (optional, if queried often)
            $table->index('last_name'); // Index for last name (optional, if queried often)
            $table->index('username'); // Index for username (unique constraint already exists)
            $table->index('email'); // Index for email (unique constraint already exists)
            $table->index('status'); // Index for status (frequently filtered)
            $table->index('is_verify'); // Index for email verification status
            $table->index('otp_send_at'); // Index for OTP sent timestamp
            $table->index('phone'); // Index for phone (optional, if queried often)
            $table->index('created_at'); // Index for soft deletes
            $table->index('updated_at'); // Index for soft deletes
            $table->index('deleted_at'); // Index for soft deletes
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
