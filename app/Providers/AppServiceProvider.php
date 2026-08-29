<?php

namespace App\Providers;

use App\Models\AboutProfile;
use App\Models\Client;
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
use App\Models\Registration;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Keep indexed strings compatible with older MySQL/MariaDB servers
        // whose utf8mb4 indexes are limited to 1000 bytes.
        Schema::defaultStringLength(191);

        $resourcePermissions = [
            HomeSlide::class => 'home_page',
            AboutProfile::class => 'about_us',
            Client::class => 'about_us',
            Registration::class => 'about_us',
            ManagementMember::class => 'management',
            CoreStaffMember::class => 'core_staff',
            Service::class => 'services',
            Project::class => 'projects',
            ProjectCategory::class => 'projects',
            Page::class => 'pages',
            Content::class => 'pages',
            ContactSetting::class => 'contact',
            Inquiry::class => 'inquiries',
            JobOpening::class => 'job_openings',
            JobApplication::class => 'job_applications',
            Setting::class => 'settings',
        ];

        Gate::before(function (User $user, string $ability, mixed $arguments = null) use ($resourcePermissions): ?bool {
            $subject = is_array($arguments) ? ($arguments[0] ?? null) : $arguments;
            $modelClass = is_object($subject) ? $subject::class : $subject;

            if ($modelClass === User::class) {
                return $user->is_super_admin;
            }

            if (isset($resourcePermissions[$modelClass])) {
                return $user->hasPermission($resourcePermissions[$modelClass]);
            }

            return $user->is_super_admin ? true : null;
        });
    }
}
