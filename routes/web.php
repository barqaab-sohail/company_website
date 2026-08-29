<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Models\Content;
use App\Models\Page;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

Route::get('/session/keep-alive', function () {
    // Touch the server-side session so an open Filament login form never
    // submits with an expired CSRF token.
    session()->put('last_activity_at', now()->timestamp);

    return response()->noContent();
})->name('session.keep-alive');

Route::get('/sitemap.xml', function () {
    return response()->view('seo.sitemap', [
        'pages' => Page::whereStatus('published')->get(['slug', 'updated_at']),
        'projects' => Project::whereStatus('published')->get(['slug', 'updated_at']),
        'contentItems' => Content::whereStatus('published')->get(['slug', 'type', 'updated_at']),
    ])->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', fn () => response(
    app()->isProduction()
        ? "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /livewire\nSitemap: ".url('/sitemap.xml')."\n"
        : "User-agent: *\nDisallow: /\n",
    200,
    ['Content-Type' => 'text/plain']
))->name('robots');

Route::get('/health', function () {
    $checks = ['application' => true, 'database' => false, 'cache' => false, 'storage' => false];

    try { DB::select('SELECT 1'); $checks['database'] = true; } catch (\Throwable) {}
    try { Cache::put('health-check', now()->timestamp, 10); $checks['cache'] = Cache::has('health-check'); } catch (\Throwable) {}
    $checks['storage'] = is_writable(storage_path('framework')) && is_writable(storage_path('logs'));

    $healthy = ! in_array(false, $checks, true);

    return response()->json(['status' => $healthy ? 'ok' : 'degraded', 'checks' => $checks], $healthy ? 200 : 503);
})->middleware('throttle:30,1')->name('health');

Route::get('/', [SiteController::class,'home'])->name('home');
Route::get('/barqaab', [SiteController::class,'about'])->name('about');
Route::redirect('/about-us', '/barqaab', 301);
Route::get('/management', [SiteController::class,'management'])->name('management');
Route::get('/core-staff', [SiteController::class,'coreStaff'])->name('core-staff');
Route::get('/services', [SiteController::class,'services'])->name('services');
Route::get('/contact', [SiteController::class,'contactPage'])->name('contact');
Route::redirect('/contact-us', '/contact', 301);
Route::get('/careers/submit-cv', [SiteController::class,'careers'])->name('careers');
Route::redirect('/careers', '/careers/submit-cv', 301);
Route::post('/careers/submit-cv', [SiteController::class,'submitCareer'])->middleware('throttle:career-form')->name('careers.submit');
Route::get('/portfolio', [SiteController::class,'projects'])->name('projects');
Route::redirect('/projects', '/portfolio', 301);
Route::get('/portfolios/{slug}', [SiteController::class,'project'])->name('projects.show');
Route::get('/news', fn()=>app(SiteController::class)->listing('post'))->name('news');
Route::get('/jobs', fn()=>app(SiteController::class)->listing('job'))->name('jobs');
Route::post('/contact', [SiteController::class,'contact'])->middleware('throttle:contact-form')->name('contact.submit');
Route::post('/jobs/{job}/apply', [SiteController::class,'apply'])->middleware('throttle:career-form')->name('jobs.apply');
Route::get('/{slug}', [SiteController::class,'show'])->name('content.show');
