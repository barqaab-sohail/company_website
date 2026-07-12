<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Project;
use App\Models\User;
use App\Models\JobOpening;
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

        $response->assertStatus(200);
    }

    public function test_the_about_page_matches_the_legacy_route(): void
    {
        $this->get('/barqaab')
            ->assertOk()
            ->assertSee('ABOUT US')
            ->assertSee('All BARQAAB Offices are ISO 9001:2015');

        $this->get('/about-us')->assertRedirect('/barqaab');
    }

    public function test_the_management_page_is_available(): void
    {
        $this->get('/management')
            ->assertOk()
            ->assertSee('Chief Executive Officer')
            ->assertSee('Engr. Muhammad Zafar')
            ->assertSee('GM (Water &amp; Coordination)', false);
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

    public function test_career_form_lists_jobs_and_saves_multiple_education_entries(): void
    {
        Storage::fake('public');
        $job = JobOpening::create(['title'=>'Electrical Engineer','slug'=>'electrical-engineer','is_active'=>true]);

        $this->get('/careers/submit-cv')->assertOk()->assertSee('General Purpose')->assertSee('Electrical Engineer');

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
