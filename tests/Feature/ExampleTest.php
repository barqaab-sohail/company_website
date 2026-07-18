<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\CoreStaffMember;
use App\Models\HomeSlide;
use App\Models\Project;
use App\Models\User;
use App\Models\JobOpening;
use App\Models\Page;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee('data-home-slider', false)
            ->assertSee('class="legacy-home"', false)
            ->assertSee('data-home-slide', false)
            ->assertDontSee('Our Core Sectors');
    }

    public function test_home_page_slides_can_be_managed_from_the_backend(): void
    {
        HomeSlide::create([
            'project_name' => 'Test Hydropower Project',
            'image_path' => '/uploads/2014/11/slider2.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Test Hydropower Project')
            ->assertSee('/uploads/2014/11/slider2.jpg', false);

        $administrator = User::factory()->create();

        $this->actingAs($administrator)
            ->get('/admin/home-page')
            ->assertOk()
            ->assertSee('Home Page Slides')
            ->assertSee('Test Hydropower Project');

        $this->actingAs($administrator)
            ->get('/admin/home-page/create')
            ->assertOk()
            ->assertSee('Project Name')
            ->assertSee('Project Picture')
            ->assertSee('Show on Home Page');
    }

    public function test_the_about_page_matches_the_legacy_route(): void
    {
        $this->get('/barqaab')
            ->assertOk()
            ->assertSee('ABOUT US')
            ->assertSee('Engineering experience at national scale')
            ->assertSee('Organization Chart')
            ->assertSee('Pakistan Engineering Council')
            ->assertSee('Our Clients')
            ->assertSee('WAPDA')
            ->assertSee('Certified Management Systems')
            ->assertSee('9001:2015')
            ->assertSee('data-about-go-top', false)
            ->assertSee('Go to top of About Us page');

        $this->get('/about-us')->assertRedirect('/barqaab');
    }

    public function test_the_management_page_is_available(): void
    {
        $this->get('/management')
            ->assertOk()
            ->assertSee('Executive Leadership')
            ->assertSee('class="management-header"', false)
            ->assertSee('class="manager-photo"', false)
            ->assertSee('Chief Executive Officer')
            ->assertSee('Engr. Muhammad Zafar')
            ->assertSee('GM (Water &amp; Coordination)', false);
    }

    public function test_the_core_staff_page_lists_complete_professional_profiles(): void
    {
        CoreStaffMember::create([
            'name' => 'Engr. Test Professional',
            'designation' => 'Chief Design Engineer',
            'qualifications' => "M.Sc. Engineering\nB.Sc. Engineering",
            'years_experience' => 'Over 25 years',
            'expertise_summary' => 'Specialist in multidisciplinary engineering design.',
            'is_active' => true,
        ]);

        $this->get('/core-staff')
            ->assertOk()
            ->assertSee('CORE STAFF')
            ->assertSee('Engr. Test Professional')
            ->assertSee('Chief Design Engineer')
            ->assertSee('Over 25 years of experience')
            ->assertSee('Qualifications')
            ->assertSee('Expertise');

        $this->get('/management')->assertDontSee('Engr. Test Professional');
    }

    public function test_project_gallery_and_detail_pages_are_available(): void
    {
        $project = Project::create([
            'category' => 'power-projects', 'title' => 'Test Power Project',
            'slug' => 'test-power-project', 'status' => 'published', 'published_at' => now(),
            'scope_of_project' => 'Project scope', 'scope_of_services' => 'Consulting services',
        ]);

        $this->get('/portfolio')->assertOk()->assertSee('Test Power Project');
        $this->get('/portfolios/'.$project->slug)
            ->assertOk()->assertSee('Scope of the Project')->assertSee('Scope of Services');
    }

    public function test_the_complete_services_page_is_available(): void
    {
        $this->get('/services')
            ->assertOk()
            ->assertSee('FEASIBILITY AND PRE FEASIBILITY STUDIES')
            ->assertSee('CONSTRUCTION SUPERVISION AND CONTRACT MANAGEMENT')
            ->assertSee('POWER SYSTEM STUDIES')
            ->assertSee('ENVIRONMENTAL &amp; RESETTLEMENT STUDIES', false);
    }

    public function test_contact_messages_are_validated_and_saved(): void
    {
        $this->get('/contact')->assertOk()->assertSee('BARQAAB Consulting Services');

        $this->post('/contact', [
            'name' => 'Website Visitor', 'email' => 'visitor@example.com',
            'subject' => 'Project enquiry', 'message' => 'Please contact me about a project.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'email' => 'visitor@example.com', 'subject' => 'Project enquiry', 'status' => 'new',
        ]);

        $this->post('/contact', [])->assertSessionHasErrors(['name','email','subject','message']);
    }

    public function test_filament_services_listing_loads_for_an_administrator(): void
    {
        $administrator = User::factory()->create();

        $this->actingAs($administrator)
            ->get('/admin/services')
            ->assertOk()
            ->assertSee('Feasibility and Pre Feasibility Studies');
    }

    public function test_filament_core_staff_listing_is_available_for_an_administrator(): void
    {
        CoreStaffMember::create([
            'name' => 'Engr. Core Staff',
            'designation' => 'Senior Engineer',
            'years_experience' => '20 years',
            'is_active' => true,
        ]);
        $administrator = User::factory()->create();

        $this->actingAs($administrator)
            ->get('/admin/core-staff')
            ->assertOk()
            ->assertSee('Core Staff')
            ->assertSee('Engr. Core Staff')
            ->assertSee('20 years');
    }

    public function test_filament_management_listing_is_separate_from_core_staff(): void
    {
        $administrator = User::factory()->create();

        $this->actingAs($administrator)
            ->get('/admin/management')
            ->assertOk()
            ->assertSee('Management')
            ->assertSee('Engr. Muhammad Zafar')
            ->assertDontSee('Engr. Core Staff');
    }

    public function test_about_us_has_a_dedicated_backend_and_is_excluded_from_pages(): void
    {
        $administrator = User::factory()->create();
        Page::updateOrCreate(
            ['slug' => 'about-us'],
            ['title' => 'Hidden About Page Record', 'status' => 'published'],
        );

        $this->actingAs($administrator)
            ->get('/admin/about-us')
            ->assertOk()
            ->assertSee('About Us')
            ->assertSee('Organization Units')
            ->assertSee('Registrations')
            ->assertSee('Clients')
            ->assertSee('Overview')
            ->assertSee('Organization Chart')
            ->assertSee('Registration')
            ->assertSee('Expertise');

        $this->actingAs($administrator)
            ->get('/admin/about-us/1/overview')
            ->assertOk()
            ->assertSee('About Us - Overview')
            ->assertSee('Introduction');

        $this->actingAs($administrator)->get('/admin/about-us/1/organization-chart')->assertOk()->assertSee('Organization Chart');
        $this->actingAs($administrator)->get('/admin/about-us/1/registration')->assertOk()->assertSee('Add registration');
        $this->actingAs($administrator)->get('/admin/about-us/1/clients')->assertOk()->assertSee('Add client');
        $this->actingAs($administrator)->get('/admin/about-us/1/expertise')->assertOk()->assertSee('Expertise');

        $this->actingAs($administrator)
            ->get('/admin/pages')
            ->assertOk()
            ->assertDontSee('Hidden About Page Record');
    }

    public function test_job_opening_admin_uses_qualification_and_experience_fields(): void
    {
        $administrator = User::factory()->create();

        $this->actingAs($administrator)
            ->get('/admin/job-openings/create')
            ->assertOk()
            ->assertSee('Minimum Qualification')
            ->assertSee('Experience Required')
            ->assertDontSee('Summary')
            ->assertDontSee('Description');
    }

    public function test_career_form_lists_jobs_and_saves_multiple_education_entries(): void
    {
        Storage::fake('public');
        $job = JobOpening::create(['title'=>'Electrical Engineer','slug'=>'electrical-engineer','minimum_qualification'=>'B.Sc. Electrical Engineering','experience_required'=>'At least 5 years of relevant experience','is_active'=>true]);

        $this->get('/careers/submit-cv')->assertOk()->assertSee('General Purpose')->assertSee('Electrical Engineer')->assertSee('Minimum Qualification')->assertSee('B.Sc. Electrical Engineering')->assertSee('Experience Required')->assertSee('At least 5 years of relevant experience');

        $this->post('/careers/submit-cv', [
            'first_name'=>'Ali','last_name'=>'Khan','address'=>'Lahore','city'=>'Lahore','phone'=>'03001234567',
            'contact_type'=>'mobile','email'=>'ali@example.com','regarding_job'=>$job->id,'total_experience'=>12,
            'education'=>[['qualification'=>'B.S (Electrical)','year'=>2008],['qualification'=>'M.Sc (Electrical)','year'=>2012]],
            'resume'=>UploadedFile::fake()->create('resume.pdf',200,'application/pdf'),
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('job_applications',['email'=>'ali@example.com','job_opening_id'=>$job->id,'total_experience'=>12]);
        $this->assertCount(2, \App\Models\JobApplication::whereEmail('ali@example.com')->first()->education);
    }
}
