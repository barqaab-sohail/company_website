@extends('layouts.legacy-page')
@section('title', 'BARQAAB | SERVICES')
@section('content')
<section class="services-page">
    <header class="services-hero">
        <div class="services-hero-copy">
            <p class="services-eyebrow">Engineering expertise</p>
            <h1>SERVICES</h1>
            <p>From early-stage studies to construction supervision and post-completion support, BARQAAB provides integrated consulting services throughout the project lifecycle.</p>
        </div>
        <div class="services-hero-stat" aria-label="{{ $services->count() }} specialist service areas">
            <strong>{{ str_pad($services->count(), 2, '0', STR_PAD_LEFT) }}</strong>
            <span>Specialist<br>service areas</span>
        </div>
    </header>

    <div class="services-intro">
        <p>What we deliver</p>
        <h2>Practical expertise for complex infrastructure.</h2>
        <span>Our multidisciplinary teams combine technical depth, local knowledge and rigorous project management to deliver dependable outcomes.</span>
    </div>

    <div class="services-grid">
        @foreach($services as $index => $service)
            <article class="service-card">
                <div class="service-media">
                    @if($service->image)<img src="{{ $service->image_url }}" alt="{{ $service->title }}">@endif
                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="service-copy">
                    <p>BARQAAB expertise</p>
                    <h2>{{ $service->title }}</h2>
                    @if($service->description)<div class="service-description">{{ $service->description }}</div>@endif
                    @if(count($service->items ?? []))
                        <ul>@foreach($service->items as $item)<li>{{ $item }}</li>@endforeach</ul>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection
