<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

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
Route::post('/careers/submit-cv', [SiteController::class,'submitCareer'])->name('careers.submit');
Route::get('/portfolio', [SiteController::class,'projects'])->name('projects');
Route::redirect('/projects', '/portfolio', 301);
Route::get('/portfolios/{slug}', [SiteController::class,'project'])->name('projects.show');
Route::get('/news', fn()=>app(SiteController::class)->listing('post'))->name('news');
Route::get('/jobs', fn()=>app(SiteController::class)->listing('job'))->name('jobs');
Route::post('/contact', [SiteController::class,'contact'])->name('contact.submit');
Route::post('/jobs/{job}/apply', [SiteController::class,'apply'])->name('jobs.apply');
Route::get('/{slug}', [SiteController::class,'show'])->name('content.show');
