<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('role')
                ->nullable()
                ->after('password');

            $table->foreignId('hostel_id')
                ->nullable()
                ->after('role')
                ->constrained('hostels')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['hostel_id']);
            $table->dropColumn(['hostel_id', 'role']);

        });
    }
};
