<?php

namespace Tests\Feature;

use Tests\TestCase;

class SessionKeepAliveTest extends TestCase
{
    public function test_login_snapshot_can_be_posted_to_livewire(): void
    {
        $page = $this->get('/admin/login');
        preg_match('/wire:snapshot="([^"]+)"/', $page->getContent(), $matches);
        $snapshot = html_entity_decode($matches[1], ENT_QUOTES);

        $response = $this->withHeader('X-CSRF-TOKEN', session()->token())
            ->postJson('/livewire/update', [
                '_token' => session()->token(),
                'components' => [[
                    'snapshot' => $snapshot,
                    'updates' => [],
                    'calls' => [],
                ]],
            ]);

        $response->assertOk();
    }

    public function test_keep_alive_endpoint_touches_the_session(): void
    {
        $response = $this->get(route('session.keep-alive'));

        $response->assertNoContent();
        $response->assertSessionHas('last_activity_at');
    }

    public function test_admin_login_includes_automatic_session_recovery(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('session\\/keep-alive', false)
            ->assertSee("status !== 419", false);
    }
}
