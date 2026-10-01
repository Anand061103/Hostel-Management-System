<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_orders', function (Blueprint $table) {
            $table->foreignId('student_id')
                ->after('id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->dropForeign(['fee_id']);
            $table->dropColumn('fee_id');
        });
    }

    public function down(): void
    {
        Schema::table('payment_orders', function (Blueprint $table) {
            $table->foreignId('fee_id')
                ->after('id')
                ->constrained('fees')
                ->cascadeOnDelete();

            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });
    }
};