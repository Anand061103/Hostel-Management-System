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
        Schema::create('apartments', function (Blueprint $table) {

            $table->id();

            // Apartment owner
            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Basic property details
            $table->string('name');

            $table->string('photo')->nullable();

            // Address details
            $table->text('address');

            $table->string('city');

            $table->string('state');

            $table->string('pincode', 10);

            // Property classification
            $table->string('type');

            // Active / inactive property
            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};