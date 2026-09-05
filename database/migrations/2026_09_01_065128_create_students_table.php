<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('father_name');

            $table->string('email', 191)->nullable()->unique();
            $table->string('aadhar_number', 12)->unique();
            $table->string('mobile_number', 15);

            $table->text('address');

            $table->string('image')->nullable();

            $table->date('joining_date');

            $table->enum('status', [
                'active',
                'checked_out',
                'inactive',
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};