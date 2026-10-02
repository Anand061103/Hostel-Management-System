<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_number', 20)->nullable()->after('email');

            $table->enum('management_type', [
                'hostel',
                'apartment'
            ])->nullable()->after('mobile_number');

            $table->string('pan_number', 10)->nullable()->after('management_type');

            $table->string('bank_account_holder_name')
                ->nullable()
                ->after('account_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'mobile_number',
                'management_type',
                'pan_number',
                'bank_account_holder_name',
            ]);
        });
    }
};