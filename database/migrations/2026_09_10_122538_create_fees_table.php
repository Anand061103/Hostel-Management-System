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
       Schema::create('fees', function (Blueprint $table) {
    $table->id();

    $table->foreignId('student_id')
        ->constrained('students')
        ->cascadeOnDelete();

    $table->string('fee_type', 50);
    $table->text('description')->nullable();

    $table->decimal('amount', 10, 2);

    $table->date('period_start')->nullable();
    $table->date('period_end')->nullable();

    $table->date('due_date');

    $table->enum('status', [
        'pending',
        'partial',
        'paid',
        'cancelled'
    ])->default('pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
