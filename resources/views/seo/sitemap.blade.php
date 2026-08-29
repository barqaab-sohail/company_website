{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach([route('home'),route('about'),route('management'),route('core-staff'),route('services'),route('projects'),route('careers'),route('contact'),route('news'),route('jobs')] as $staticUrl)<url><loc>{{ $staticUrl }}</loc><changefreq>weekly</changefreq><priority>{{ $loop->first ? '1.0' : '0.7' }}</priority></url>@endforeach
@foreach($pages as $page)<url><loc>{{ route('content.show',$page->slug) }}</loc><lastmod>{{ $page->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>@endforeach
@foreach($projects as $project)<url><loc>{{ route('projects.show',$project->slug) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>@endforeach
@foreach($contentItems as $item)<url><loc>{{ route('content.show',$item->slug) }}</loc><lastmod>{{ $item->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq><priority>0.5</priority></url>@endforeach
</urlset>
