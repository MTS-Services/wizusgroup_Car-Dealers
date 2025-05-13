<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Admin;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique()->min(5)->max(20)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(Admin::STATUS_ACTIVE)->comment(Admin::STATUS_ACTIVE . ': Active, ' . Admin::STATUS_DEACTIVE . ': Inactive');
            $table->boolean('is_verify')->default(Admin::UNVERIFIED)->comment(Admin::UNVERIFIED . ': Unverified, ' . Admin::VERIFIED . ': Verified');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            // Add the otp_send_at column (if it doesn't exist already)
            $table->timestamp('otp_send_at')->nullable(); // Add this line

            // Indexes
            $table->index('first_name'); // Index for first name (optional, if queried often)
            $table->index('last_name'); // Index for last name (optional, if queried often)
            $table->index('username'); // Index for username (unique constraint already exists)
            $table->index('email'); // Index for email (unique constraint already exists)
            $table->index('phone'); // Index for phone (optional, if queried often
            $table->index('status'); // Index for status (frequently filtered)
            $table->index('is_verify'); // Index for email verification status
            $table->index('otp_send_at'); // Index for OTP sent timestamp
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
        Schema::dropIfExists('admins');
    }
};
