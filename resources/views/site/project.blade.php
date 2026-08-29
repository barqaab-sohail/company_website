@extends('layouts.legacy-page')
@section('title', 'BARQAAB | '.$project->title)
@section('content')
<article class="project-page">
    <h1>{{ $project->title }}</h1>
    @if($project->subtitle)<h2 class="project-subtitle">{{ $project->subtitle }}</h2>@endif
    @if($project->mainImages->isNotEmpty())
        <section class="project-main-pictures{{ $project->mainImages->count() > 1 ? ' has-slides' : '' }}" data-project-slideshow>
            <div class="project-slides">
                @foreach($project->mainImages as $image)
                    <figure class="project-slide{{ $loop->first ? ' is-active' : '' }}" aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
                        <img src="{{ $image->url }}" alt="{{ $image->alt_text ?: $project->title }}" @if(!$loop->first) loading="lazy" @else fetchpriority="high" @endif decoding="async">
                        @if($image->caption)<figcaption>{{ $image->caption }}</figcaption>@endif
                    </figure>
                @endforeach
            </div>
            @if($project->mainImages->count() > 1)
                <button type="button" class="project-slide-prev" aria-label="Previous picture">&#10094;</button>
                <button type="button" class="project-slide-next" aria-label="Next picture">&#10095;</button>
                <div class="project-slide-dots" aria-label="Choose project picture">
                    @foreach($project->mainImages as $image)<button type="button" class="{{ $loop->first ? 'is-active' : '' }}" aria-label="Show picture {{ $loop->iteration }}"></button>@endforeach
                </div>
            @endif
        </section>
    @endif
    <div class="project-body">{!! $project->body !!}</div>
    @php
        $attributes = collect($project->attributes_data ?? [])->filter(
            fn ($attribute) => is_array($attribute)
                && filled($attribute['label'] ?? null)
                && filled($attribute['value'] ?? null)
        );
    @endphp
    @if($attributes->isNotEmpty())
        <ul class="project-attributes">
            @foreach($attributes as $attribute)
                <li><strong>{{ $attribute['label'] }}:</strong> {{ $attribute['value'] }}</li>
            @endforeach
        </ul>
    @endif
    @if($project->scope_of_project || $project->scope_of_services)
        <div class="project-scopes">
            @if($project->scope_of_project)<section><h3>Scope of the Project</h3><div>{!! nl2br(e($project->scope_of_project)) !!}</div></section>@endif
            @if($project->scope_of_services)<section><h3>Scope of Services</h3><div>{!! nl2br(e($project->scope_of_services)) !!}</div></section>@endif
        </div>
    @endif
    @if($project->galleryImages->isNotEmpty())
        <section class="project-gallery"><h3>Project Gallery</h3><div>@foreach($project->galleryImages as $image)<figure><img src="{{ $image->url }}" alt="{{ $image->alt_text ?: $project->title }}" loading="lazy" decoding="async">@if($image->caption)<figcaption>{{ $image->caption }}</figcaption>@endif</figure>@endforeach</div></section>
    @endif
</article>
@if($project->mainImages->count() > 1)
<script>
document.querySelectorAll('[data-project-slideshow]').forEach(slideshow => {
    const slides = [...slideshow.querySelectorAll('.project-slide')];
    const dots = [...slideshow.querySelectorAll('.project-slide-dots button')];
    let current = 0;
    const show = index => {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, position) => {
            slide.classList.toggle('is-active', position === current);
            slide.setAttribute('aria-hidden', position === current ? 'false' : 'true');
        });
        dots.forEach((dot, position) => dot.classList.toggle('is-active', position === current));
    };
    slideshow.querySelector('.project-slide-prev').addEventListener('click', () => show(current - 1));
    slideshow.querySelector('.project-slide-next').addEventListener('click', () => show(current + 1));
    dots.forEach((dot, index) => dot.addEventListener('click', () => show(index)));
    setInterval(() => show(current + 1), 5000);
});
</script>
@endif
@endsection
