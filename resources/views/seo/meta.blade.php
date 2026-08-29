@php
    $seoRecord = $content ?? $project ?? null;
    $seoMeta = is_array($seoRecord?->meta ?? null) ? $seoRecord->meta : [];
    $defaultTitle = trim($__env->yieldContent('title', 'BARQAAB Consulting Services'));
    $pageTitle = $seoMeta['seo_title'] ?? $defaultTitle;
    $pageDescription = $seoMeta['seo_description'] ?? ($seoRecord->excerpt ?? $seoRecord->subtitle ?? 'BARQAAB Consulting Services provides engineering solutions for water, power and infrastructure projects.');
    $canonical = $seoMeta['canonical_url'] ?? url()->current();
    $noIndex = (bool) ($seoMeta['noindex'] ?? false);
    $shareImage = $seoMeta['social_image'] ?? ($seoRecord->featured_image ?? null);
    if (! $shareImage && isset($project) && $project->mainImages->isNotEmpty()) $shareImage = $project->mainImages->first()->url;
    if ($shareImage && ! str_starts_with($shareImage, 'http')) {
        $shareImage = Str::startsWith($shareImage, ['/', 'assets/'])
            ? asset(ltrim($shareImage, '/'))
            : Storage::disk('public')->url($shareImage);
    }
@endphp
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ Str::limit(strip_tags($pageDescription), 160, '') }}">
<meta name="robots" content="{{ $noIndex ? 'noindex,nofollow' : 'index,follow,max-image-preview:large' }}">
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:type" content="{{ isset($project) ? 'article' : 'website' }}">
<meta property="og:site_name" content="BARQAAB Consulting Services">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($pageDescription), 200, '') }}">
<meta property="og:url" content="{{ $canonical }}">
@if($shareImage)<meta property="og:image" content="{{ $shareImage }}">@endif
<meta name="twitter:card" content="{{ $shareImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($pageDescription), 200, '') }}">
@if($shareImage)<meta name="twitter:image" content="{{ $shareImage }}">@endif
<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'Organization','name'=>'BARQAAB Consulting Services (Pvt.) Ltd.','url'=>url('/'),'logo'=>asset('assets/images/barqaab-logo.png'),'email'=>'info@barqaab.com.pk'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@if(isset($project))<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'Article','headline'=>$project->title,'description'=>Str::limit(strip_tags($pageDescription), 200, ''),'url'=>$canonical,'image'=>$shareImage ? [$shareImage] : [],'dateModified'=>optional($project->updated_at)->toIso8601String(),'publisher'=>['@type'=>'Organization','name'=>'BARQAAB Consulting Services']], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>@endif
