<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active;
    }

    public const PERMISSIONS = [
        'home_page' => 'Home Page',
        'about_us' => 'About Us',
        'management' => 'Management',
        'core_staff' => 'Core Staff',
        'services' => 'Services',
        'projects' => 'Projects',
        'pages' => 'Website Pages',
        'contact' => 'Contact Details',
        'inquiries' => 'Contact Inquiries',
        'job_openings' => 'Job Openings',
        'job_applications' => 'Job Applications',
        'settings' => 'Website Settings',
    ];

    public function hasPermission(string $permission): bool
    {
        return $this->is_super_admin || in_array($permission, $this->permissions ?? [], true);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_super_admin',
        'is_active',
        'permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
            'is_active' => 'boolean',
            'permissions' => 'array',
        ];
    }
}
