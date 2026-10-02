<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hostels', function (Blueprint $table) {

            // Owner of this hostel
            $table->foreignId('owner_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->nullOnDelete();

            // Basic hostel information
            $table->string('photo')->nullable()->after('name');

            $table->string('city')->nullable()->after('address');

            $table->string('state')->nullable()->after('city');

            $table->string('pincode', 10)->nullable()->after('state');

            $table->string('type')->nullable()->after('pincode');
        });
    }

    public function down(): void
    {
        Schema::table('hostels', function (Blueprint $table) {

            $table->dropForeign(['owner_id']);

            $table->dropColumn([
                'owner_id',
                'photo',
                'city',
                'state',
                'pincode',
                'type',
            ]);
        });
    }
};