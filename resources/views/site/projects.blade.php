@extends('layouts.legacy-page')
@section('title', 'BARQAAB | PROJECTS')
@section('content')
<section class="portfolio-page">
    <h1>PROJECTS</h1>
    <p class="portfolio-intro"><em>Some of the major projects undertaken by BARQAAB.</em></p>
    <div class="portfolio-filters" role="group" aria-label="Project categories">
        <button class="active" data-filter="all">All</button>
        @foreach($categories as $category)<button data-filter="{{ $category->slug }}">{{ $category->name }}</button>@endforeach
    </div>
    <div class="portfolio-grid">
        @foreach($projects as $project)
            <a class="portfolio-card" data-category="{{ $project->projectCategory?->slug ?: 'all' }}" href="{{ route('projects.show', $project->slug) }}">
                @if($project->featuredImage)<img src="{{ $project->featuredImage->url }}" alt="{{ $project->featuredImage->alt_text ?: $project->title }}" loading="lazy" decoding="async">@else<div class="portfolio-placeholder"></div>@endif
                <span><strong>{{ $project->title }}</strong><small>View project</small></span>
            </a>
        @endforeach
    </div>
</section>
<script>document.querySelectorAll('.portfolio-filters button').forEach(button=>button.addEventListener('click',()=>{document.querySelector('.portfolio-filters .active')?.classList.remove('active');button.classList.add('active');document.querySelectorAll('.portfolio-card').forEach(card=>card.hidden=button.dataset.filter!=='all'&&card.dataset.category!==button.dataset.filter)}));</script>
@endsection
