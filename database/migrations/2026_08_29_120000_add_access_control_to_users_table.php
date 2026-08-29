<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_super_admin')->default(false)->after('password');
            $table->boolean('is_active')->default(true)->after('is_super_admin');
            $table->json('permissions')->nullable()->after('is_active');
        });

        $promotedUsers = DB::table('users')
            ->where('email', 'admin@barqaab.com.pk')
            ->update(['is_super_admin' => true, 'is_active' => true]);

        // Existing installations may use a different administrator email.
        // Promote the oldest account when the seeded address is not present.
        if ($promotedUsers === 0) {
            $firstUserId = DB::table('users')->orderBy('id')->value('id');

            if ($firstUserId !== null) {
                DB::table('users')
                    ->where('id', $firstUserId)
                    ->update(['is_super_admin' => true, 'is_active' => true]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_super_admin', 'is_active', 'permissions']);
        });
    }
};
