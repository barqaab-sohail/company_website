<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SeoSecurityMonitoringTest extends TestCase
{
    public function test_robots_response_has_security_and_cache_headers(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /', false)
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Cache-Control');
    }

    public function test_monitoring_and_seo_routes_are_registered(): void
    {
        $this->assertTrue(Route::has('health'));
        $this->assertTrue(Route::has('sitemap'));
        $this->assertTrue(Route::has('robots'));
        $this->assertTrue(Route::has('filament.admin.auth.password-reset.request'));
    }

    public function test_default_seo_metadata_renders(): void
    {
        $html = view('seo.meta')->render();

        $this->assertStringContainsString('<link rel="canonical"', $html);
        $this->assertStringContainsString('application/ld+json', $html);
        $this->assertStringContainsString('og:title', $html);
    }
}
