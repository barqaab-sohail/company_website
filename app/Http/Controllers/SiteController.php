<?php

namespace App\Http\Controllers;

use App\Models\AboutProfile;
use App\Models\ContactSetting;
use App\Models\Content;
use App\Models\CoreStaffMember;
use App\Models\HomeSlide;
use App\Models\Inquiry;
use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\ManagementMember;
use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    public function home()
    {
        $slides = HomeSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (HomeSlide $slide) => [
                'project_name' => $slide->project_name,
                'image_url' => $slide->image_url,
                'project_url' => $slide->project_url,
            ]);

        if ($slides->isNotEmpty()) {
            return view('site.home', ['slides' => $slides]);
        }

        $projectsWithImages = Project::with(['featuredImage', 'projectCategory'])
            ->whereStatus('published')
            ->whereHas('featuredImage')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $featuredProjects = $projectsWithImages->unique('project_category_id')->take(6);

        if ($featuredProjects->count() < 6) {
            $featuredProjects = $featuredProjects
                ->merge($projectsWithImages->whereNotIn('id', $featuredProjects->pluck('id')))
                ->take(6);
        }

        $slides = $featuredProjects->values()->map(fn (Project $project) => [
            'project_name' => $project->title,
            'image_url' => $project->featuredImage->url,
            'project_url' => route('projects.show', $project->slug),
        ]);

        return view('site.home', ['slides' => $slides]);
    }
    public function about() { return view('site.about', ['about'=>AboutProfile::with([
        'clientRecords' => fn ($query) => $query->where('is_active', true),
        'registrationRecords' => fn ($query) => $query->where('is_active', true),
    ])->firstOrFail()]); }
    public function listing(string $type) { return view('site.listing', ['type'=>$type,'items'=>Content::whereType($type)->whereStatus('published')->latest('published_at')->paginate(12)]); }
    public function projects() { return view('site.projects', [
        'projects'=>Project::with(['featuredImage', 'projectCategory'])->whereStatus('published')->orderBy('sort_order')->orderBy('id')->get(),
        'categories'=>ProjectCategory::where('is_active', true)->whereHas('projects', fn ($query) => $query->whereStatus('published'))->orderBy('sort_order')->orderBy('name')->get(),
    ]); }
    public function project(string $slug) { return view('site.project', ['project'=>Project::with(['mainImages', 'galleryImages'])->whereStatus('published')->where('slug',$slug)->firstOrFail()]); }
    public function services() { return view('site.services', ['services'=>Service::where('is_active',true)->orderBy('sort_order')->get()]); }
    public function management() { return view('site.management', ['members'=>ManagementMember::where('is_active',true)->orderBy('sort_order')->get()]); }
    public function coreStaff() { return view('site.core-staff', ['members'=>CoreStaffMember::where('is_active',true)->orderBy('sort_order')->get()]); }
    public function contactPage() { return view('site.contact', ['contact'=>ContactSetting::query()->first() ?? new ContactSetting]); }
    public function show(string $slug) { return view('site.show', ['content'=>Page::whereStatus('published')->where('slug',$slug)->firstOrFail()]); }
    public function contact(Request $request) {
        $data=$request->validate(['name'=>'required|max:255','email'=>'required|email|max:255','phone'=>'nullable|max:50','subject'=>'required|max:255','message'=>'required|max:5000']);
        $data['source_ip']=$request->ip();
        $data['user_agent']=$request->userAgent();
        $inquiry=Inquiry::create($data);
        $notificationEmail=ContactSetting::query()->value('notification_email');

        if ($notificationEmail) {
            try {
                Mail::send('emails.contact-inquiry', ['inquiry' => $inquiry], function ($message) use ($inquiry, $notificationEmail): void {
                    $message->to($notificationEmail)
                        ->replyTo($inquiry->email, $inquiry->name)
                        ->subject('Website inquiry: '.$inquiry->subject);
                });
            } catch (\Throwable $exception) {
                Log::warning('Inquiry was stored, but email forwarding failed.', ['inquiry_id' => $inquiry->id, 'exception' => $exception->getMessage()]);
            }
        }

        return back()->with('success','Thank you. Your message has been received.');
    }
    public function careers() { return view('site.careers', ['jobs'=>JobOpening::where('is_active',true)->where(fn($q)=>$q->whereNull('closing_date')->orWhereDate('closing_date','>=',today()))->orderBy('sort_order')->get()]); }
    public function submitCareer(Request $request) {
        $data=$request->validate([
            'first_name'=>'required|max:255','last_name'=>'required|max:255','address'=>'required|max:500','city'=>'required|max:255',
            'phone'=>'required|max:50','contact_type'=>'required|in:home,mobile,work,other','email'=>'required|email|max:255',
            'regarding_job'=>'required','education'=>'required|array|min:1','education.*.qualification'=>'required|max:255',
            'education.*.year'=>'required|integer|min:1940|max:'.date('Y'),'total_experience'=>'required|numeric|min:0|max:80',
            'resume'=>'required|file|mimes:pdf,doc,docx|max:10240',
        ]);
        $job=null; if($data['regarding_job']!=='general') $job=JobOpening::where('is_active',true)->findOrFail($data['regarding_job']);
        JobApplication::create([
            'job_opening_id'=>$job?->id,'application_type'=>$job?'job':'general','first_name'=>$data['first_name'],'last_name'=>$data['last_name'],
            'name'=>$data['first_name'].' '.$data['last_name'],'address'=>$data['address'],'city'=>$data['city'],'phone'=>$data['phone'],
            'contact_type'=>$data['contact_type'],'email'=>$data['email'],'education'=>$data['education'],'total_experience'=>$data['total_experience'],
            'resume_path'=>$request->file('resume')->store('resumes','public'),'status'=>'new','source_ip'=>$request->ip(),
        ]);
        return back()->with('success','Your CV has been submitted successfully.');
    }
    public function apply(Request $request, Content $job) { $data=$request->validate(['name'=>'required|max:255','email'=>'required|email|max:255','phone'=>'nullable|max:50','cover_letter'=>'nullable|max:5000','resume'=>'nullable|file|mimes:pdf,doc,docx|max:5120']); $data['content_id']=$job->id; if($request->hasFile('resume')) $data['resume_path']=$request->file('resume')->store('resumes','public'); JobApplication::create($data); return back()->with('success','Your application has been submitted.'); }
}
