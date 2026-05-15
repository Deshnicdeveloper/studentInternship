<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id')->nullable()->unique()->after('email');
            $table->string('phone')->nullable()->after('student_id');
            $table->string('department')->nullable()->after('phone');
            $table->string('profile_photo')->nullable()->after('department');
            $table->boolean('is_active')->default(true)->after('profile_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['student_id', 'phone', 'department', 'profile_photo', 'is_active']);
        });
    }
};
