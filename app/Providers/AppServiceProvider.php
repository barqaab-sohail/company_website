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
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
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

        RateLimiter::for('contact-form', fn (Request $request) => [
            Limit::perMinute(5)->by($request->ip()),
            Limit::perHour(10)->by(strtolower((string) $request->input('email')).'|'.$request->ip()),
        ]);

        RateLimiter::for('career-form', fn (Request $request) => [
            Limit::perHour(5)->by($request->ip()),
            Limit::perDay(10)->by(strtolower((string) $request->input('email')).'|'.$request->ip()),
        ]);

        Event::listen(Login::class, fn (Login $event) => Log::channel('security')->info('Admin login succeeded.', [
            'user_id' => $event->user->getAuthIdentifier(),
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        Event::listen(Failed::class, fn (Failed $event) => Log::channel('security')->warning('Admin login failed.', [
            'email' => $event->credentials['email'] ?? null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        Event::listen(Logout::class, fn (Logout $event) => Log::channel('security')->info('Admin logout.', [
            'user_id' => $event->user?->getAuthIdentifier(),
            'ip' => request()->ip(),
        ]));

        User::updated(function (User $user): void {
            $changes = array_keys($user->getChanges());

            if (array_intersect($changes, ['email', 'password', 'is_super_admin', 'is_active', 'permissions'])) {
                Log::channel('security')->notice('User security settings changed.', [
                    'user_id' => $user->getKey(),
                    'changed_fields' => array_values(array_diff($changes, ['password', 'updated_at'])),
                    'password_changed' => in_array('password', $changes, true),
                    'actor_id' => auth()->id(),
                    'ip' => request()->ip(),
                ]);
            }
        });
    }
}
