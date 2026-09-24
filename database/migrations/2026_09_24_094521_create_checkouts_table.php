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
       Schema::create('checkouts', function (Blueprint $table) {
    $table->id();

    $table->foreignId('student_id')
        ->constrained('students')
        ->cascadeOnDelete();

    $table->foreignId('room_id')
        ->constrained('rooms')
        ->cascadeOnDelete();

    $table->foreignId('bed_id')
        ->constrained('beds')
        ->cascadeOnDelete();

    $table->date('checkout_date');

    $table->string('reason')->nullable();

    $table->text('notes')->nullable();

    // Final fee snapshot
    $table->decimal('fee_outstanding', 10, 2)->default(0);

    // Final security settlement snapshot
    $table->decimal('security_deposit_amount', 10, 2)->default(0);
    $table->decimal('security_deduction', 10, 2)->default(0);
    $table->decimal('security_refund', 10, 2)->default(0);

    $table->string('refund_method')->nullable();
    $table->string('refund_reference')->nullable();

    // User who processed checkout
    $table->foreignId('created_by')
        ->constrained('users')
        ->restrictOnDelete();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
