<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('About Us');
            $table->string('eyebrow')->nullable();
            $table->text('hero_text')->nullable();
            $table->json('highlights')->nullable();
            $table->string('overview_heading')->nullable();
            $table->longText('overview_body')->nullable();
            $table->string('organization_heading')->nullable();
            $table->text('organization_intro')->nullable();
            $table->json('organization_units')->nullable();
            $table->json('registrations')->nullable();
            $table->text('clients_intro')->nullable();
            $table->json('clients')->nullable();
            $table->string('expertise_heading')->nullable();
            $table->longText('expertise_body')->nullable();
            $table->timestamps();
        });

        DB::table('about_profiles')->insert([
            'title' => 'About Us',
            'eyebrow' => 'Engineering Excellence Since 2000',
            'hero_text' => 'BARQAAB Consulting Services was established in May 2000 as an engineering consulting company. Its core team has unmatched experience on WAPDA’s water and power-sector projects. Approximately 350 professionals, ranging from young engineers to senior specialists, form part of an overall staff strength of 550.',
            'highlights' => json_encode([
                ['value' => '2000', 'label' => 'Established in Lahore'],
                ['value' => 'Multidisciplinary', 'label' => 'Engineering professionals'],
                ['value' => 'Nationwide', 'label' => 'Project experience'],
                ['value' => 'Independent + JV', 'label' => 'Flexible project delivery'],
            ]),
            'overview_heading' => 'Engineering experience at national scale',
            'overview_body' => '<p><strong>BARQAAB has successfully implemented major projects independently and as a joint venture partner across the water and power sectors.</strong></p><p>BARQAAB independently planned, designed and supervised construction of the Rainee Canal Project, including its 10,000-cusecs headwork at Guddu Barrage, 111 km of main and branch canals, 133 km of distributary and minor canals, and 394 structures of various types.</p><p>Other landmark water-sector assignments include the Muzaffargarh Canal Rehabilitation and Lining Project as lead firm, Mangla Dam Raising Project, and New Khanki Barrage as a major joint venture partner.</p><p>BARQAAB was a major joint venture partner for the detailed design of Diamer Basha Dam Project. The company also independently completed feasibility work for the Mangla-Marala Link Canal and feasibility studies for numerous dams across Pakistan.</p>',
            'organization_heading' => 'How BARQAAB is organized',
            'organization_intro' => 'The Chief Executive Officer is supported by general management, technical divisions and corporate support functions working together across project assignments.',
            'organization_units' => json_encode([
                ['title' => 'Chief Executive Officer', 'details' => "Executive leadership\nCorporate governance"],
                ['title' => 'Power Division', 'details' => "Transmission & Grid Stations\nDistribution\nPower System Studies\nProject Management"],
                ['title' => 'Water Division', 'details' => "Dams & Hydropower\nIrrigation & Drainage\nHydraulics & Structures\nConstruction Management"],
                ['title' => 'Infrastructure Division', 'details' => "Buildings & Highways\nWater Supply & Sanitation\nContract Management"],
                ['title' => 'Specialist Services', 'details' => "Environment & Resettlement\nSurvey & GIS\nQuality Assurance"],
                ['title' => 'Corporate Services', 'details' => "Business Development & IT\nFinance\nHuman Resources"],
            ]),
            'registrations' => json_encode([
                ['title' => 'Securities and Exchange Commission of Pakistan', 'number' => 'Registered private limited company', 'details' => 'Registered in May 2000.'],
                ['title' => 'Pakistan Engineering Council', 'number' => 'CONSULT/939', 'details' => 'Registered engineering consulting organization.'],
                ['title' => 'Federal Board of Revenue', 'number' => 'FBR Registered', 'details' => null],
                ['title' => 'Sindh Revenue Board', 'number' => 'SRB Registered', 'details' => null],
                ['title' => 'Lahore Chamber of Commerce & Industry', 'number' => 'Member', 'details' => null],
                ['title' => 'ISO Management Systems', 'number' => '9001:2015 · 14001:2015 · 45001:2018', 'details' => 'Quality, environmental, occupational health and safety management systems.'],
            ]),
            'clients_intro' => 'BARQAAB serves public-sector authorities, utilities, development organizations and private-sector clients throughout Pakistan.',
            'clients' => json_encode([
                ['name' => 'WAPDA', 'logo' => null, 'website' => null],
                ['name' => 'NTDC', 'logo' => null, 'website' => null],
                ['name' => 'Punjab Irrigation Department', 'logo' => null, 'website' => null],
                ['name' => 'LESCO', 'logo' => null, 'website' => null],
                ['name' => 'MEPCO', 'logo' => null, 'website' => null],
                ['name' => 'IESCO', 'logo' => null, 'website' => null],
                ['name' => 'GEPCO', 'logo' => null, 'website' => null],
                ['name' => 'HESCO', 'logo' => null, 'website' => null],
                ['name' => 'QESCO', 'logo' => null, 'website' => null],
                ['name' => 'PEDO', 'logo' => null, 'website' => null],
            ]),
            'expertise_heading' => 'From project identification to implementation',
            'expertise_body' => '<p>BARQAAB’s consultancy services cover multiple engineering disciplines, with particular strength in water and power resources development. Services include surveys, field investigations, project identification, concept development, pre-feasibility and feasibility studies, prioritization, detailed design and implementation of irrigation, drainage, dam and hydropower projects.</p><p>The company also provides specialist expertise in hydrogeology and groundwater management.</p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('about_profiles');
    }
};
