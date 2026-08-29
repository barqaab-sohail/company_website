<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicCacheHeaders
{
    private const CACHEABLE_ROUTES = [
        'home', 'about', 'management', 'core-staff', 'services', 'projects',
        'projects.show', 'news', 'jobs', 'content.show', 'sitemap', 'robots',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && in_array($request->route()?->getName(), self::CACHEABLE_ROUTES, true) && $response->isSuccessful()) {
            $response->setMaxAge(300);

            if ($response->headers->has('Set-Cookie')) {
                $response->setPrivate();
            } else {
                $response->setPublic();
                $response->setSharedMaxAge(600);
                $response->headers->addCacheControlDirective('stale-while-revalidate', 60);
            }
        }

        return $response;
    }
}
