<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('security_payments', function (Blueprint $table) {

        $table->id();

        $table->foreignId('security_deposit_id')
            ->constrained('security_deposits')
            ->cascadeOnDelete();

        $table->decimal('amount', 10, 2);

        $table->date('payment_date');

        $table->enum('payment_method', [
            'cash',
            'upi',
            'bank_transfer',
            'card',
            'other'
        ])->default('cash');

        $table->string('reference_no')->nullable();

        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('security_payments');
}
};
