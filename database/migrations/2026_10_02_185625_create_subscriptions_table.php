<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {

            $table->id();

            // Account onboarding complete hone ke baad fill hoga
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // hostel / apartment
            $table->string('management_type');

            // trial / 399 / 999
            $table->string('plan');

            // Plan amount in rupees
            $table->decimal('amount', 10, 2)->default(0);

            // Plan validity
            $table->unsignedInteger('duration_days');

            // pending / active / expired / failed / cancelled
            $table->string('status')->default('pending');

            $table->timestamp('starts_at')->nullable();

            $table->timestamp('expires_at')->nullable();

            // Razorpay details
            $table->string('razorpay_order_id')
                ->nullable()
                ->unique();

            $table->string('razorpay_payment_id')
                ->nullable();

            $table->string('razorpay_signature')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};