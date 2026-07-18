<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('management_members', function (Blueprint $table) {
            $table->string('years_experience')->nullable()->after('qualifications');
            $table->text('expertise_summary')->nullable()->after('years_experience');
            $table->boolean('is_core_staff')->default(false)->after('sort_order')->index();
        });

        $coreStaff = [
            [
                'name' => 'Engr. Muhammad Zafar',
                'designation' => 'Chief Executive Officer',
                'photo' => 'assets/images/management-muhammad-zafar.jpg',
                'qualifications' => "M.Sc. (Electrical Engineering), University of Engineering and Technology (UET), Lahore\nB.Sc. (Electrical Engineering), Mehran University of Engineering and Technology (MUET), Jamshoro",
                'years_experience' => 'Over 36 years',
                'expertise_summary' => 'Specializes in extra-high-voltage transmission lines, grid stations, construction management and delivery of major power-sector projects in Pakistan and overseas.',
                'biography' => 'He served NTDC for over 36 years and retired as General Manager. His career includes senior leadership roles in EHV construction, grid stations and transmission-line projects across Pakistan, as well as engineering assignments in Saudi Arabia.',
                'sort_order' => 0,
            ],
            [
                'name' => 'Engr. Muhammad Saleem',
                'designation' => 'General Manager (Power)',
                'photo' => 'assets/images/management-muhammad-saleem.jpg',
                'qualifications' => "M.Sc. (Electrical Engineering), University of Engineering and Technology (UET), Lahore\nMBA, University of the Punjab\nB.Sc. (Electrical Engineering) with Honors, University of Engineering and Technology (UET), Lahore",
                'years_experience' => '39 years',
                'expertise_summary' => 'Brings senior expertise in power distribution, utility operations, construction, grid stations, transmission lines and institutional leadership.',
                'biography' => 'He served WAPDA, LESCO and PEPCO for 39 years and retired as General Manager. His leadership appointments included Chief Executive Officer LESCO, General Manager PEPCO, Chief Engineer T&G and Technical Director LESCO.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Engr. Abdul Samad Qureshi',
                'designation' => 'GM (Water & Coordination)',
                'photo' => 'assets/images/management-abdul-samad-qureshi.jpg',
                'qualifications' => "Postgraduate Degree in Applied Hydraulics and Irrigation Engineering, Asian Institute of Technology (AIT), Bangkok\nB.Sc. (Civil Engineering), University of Engineering and Technology (UET), Lahore",
                'years_experience' => 'Over 55 years',
                'expertise_summary' => 'Specializes in water resources, irrigation, applied hydraulics, construction management, project coordination and multidisciplinary consulting assignments.',
                'biography' => 'A practicing professional engineer since 1970, he has worked with LDA Water Wing, NESPAK, Kano State Urban Development Board in Nigeria, WAPDA and BARQAAB on major water-resource and construction-management assignments.',
                'sort_order' => 2,
            ],
        ];

        foreach ($coreStaff as $member) {
            $existing = DB::table('management_members')->where('name', $member['name'])->exists();
            if ($existing) {
                DB::table('management_members')->where('name', $member['name'])->update([
                    'years_experience' => $member['years_experience'],
                    'expertise_summary' => $member['expertise_summary'],
                    'is_core_staff' => true,
                    'is_active' => true,
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('management_members')->insert(array_merge($member, [
                    'is_core_staff' => true,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        Schema::table('management_members', function (Blueprint $table) {
            $table->dropIndex(['is_core_staff']);
            $table->dropColumn(['years_experience', 'expertise_summary', 'is_core_staff']);
        });
    }
};
