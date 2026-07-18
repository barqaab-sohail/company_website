<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $managementNames = [
            'Engr. Muhammad Zafar',
            'Engr. Muhammad Saleem',
            'Engr. Abdul Samad Qureshi',
        ];

        $coreStaff = DB::table('management_members')
            ->where('is_core_staff', true)
            ->whereNotIn('name', $managementNames)
            ->get();

        foreach ($coreStaff as $member) {
            DB::table('core_staff_members')->updateOrInsert(
                ['name' => $member->name],
                [
                    'designation' => $member->designation,
                    'photo' => $member->photo,
                    'qualifications' => $member->qualifications,
                    'years_experience' => $member->years_experience,
                    'expertise_summary' => $member->expertise_summary,
                    'sort_order' => $member->sort_order,
                    'is_active' => $member->is_active,
                    'created_at' => $member->created_at ?? now(),
                    'updated_at' => now(),
                ],
            );
        }

        if ($coreStaff->isNotEmpty()) {
            DB::table('management_members')->whereIn('id', $coreStaff->pluck('id'))->delete();
        }

        Schema::table('management_members', function (Blueprint $table) {
            $table->dropIndex(['is_core_staff']);
            $table->dropColumn(['years_experience', 'expertise_summary', 'is_core_staff']);
        });
    }

    public function down(): void
    {
        Schema::table('management_members', function (Blueprint $table) {
            $table->string('years_experience')->nullable()->after('qualifications');
            $table->text('expertise_summary')->nullable()->after('years_experience');
            $table->boolean('is_core_staff')->default(false)->after('sort_order')->index();
        });
    }
};
