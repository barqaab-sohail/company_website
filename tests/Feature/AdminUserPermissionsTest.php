<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminUserPermissionsTest extends TestCase
{
    public function test_super_administrator_can_manage_users(): void
    {
        $administrator = new User([
            'is_super_admin' => true,
            'is_active' => true,
        ]);

        $this->actingAs($administrator);

        $this->assertTrue(Gate::allows('viewAny', User::class));
        $this->assertTrue(Gate::allows('viewAny', Project::class));
    }

    public function test_restricted_user_can_only_access_assigned_sections(): void
    {
        $user = new User([
            'is_super_admin' => false,
            'is_active' => true,
            'permissions' => ['pages'],
        ]);

        $this->actingAs($user);

        $this->assertTrue(Gate::allows('viewAny', Page::class));
        $this->assertFalse(Gate::allows('viewAny', Project::class));

        $this->assertFalse(Gate::allows('viewAny', User::class));
    }

    public function test_every_active_user_can_open_profile_and_change_password(): void
    {
        $user = new User([
            'is_super_admin' => false,
            'is_active' => true,
            'permissions' => [],
        ]);

        $this->assertTrue($user->canAccessPanel(filament()->getPanel('admin')));
        $this->assertTrue(Route::has('filament.admin.auth.profile'));
    }
}
