<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {

            $table->dropUnique('rooms_room_number_unique');

            $table->unique([
                'hostel_id',
                'room_number',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {

            $table->dropUnique([
                'hostel_id',
                'room_number',
            ]);

            $table->unique('room_number');
        });
    }

};
