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
        Schema::create('security_settlements', function (Blueprint $table) {
    $table->id();

    $table->foreignId('security_deposit_id')
        ->constrained('security_deposits')
        ->cascadeOnDelete();

    $table->decimal('deduction_amount', 10, 2)->default(0);

    $table->decimal('refund_amount', 10, 2)->default(0);

    $table->date('settlement_date');

    $table->text('reason')->nullable();

    $table->enum('status', [
        'pending',
        'completed'
    ])->default('pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_settlements');
    }
};
