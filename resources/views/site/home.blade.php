@extends('layouts.site')
@section('title', 'BARQAAB')
@section('content')
<section class="legacy-home" aria-label="BARQAAB home">
    <div class="legacy-hero" data-home-slider>
        <div class="legacy-slides">
            @forelse($slides as $slide)
                <article class="legacy-slide {{ $loop->first ? 'is-active' : '' }}" data-home-slide aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
                    <img src="{{ $slide['image_url'] }}" alt="{{ $slide['project_name'] }}" @if(!$loop->first) loading="lazy" @else fetchpriority="high" @endif>
                    <div class="legacy-slide-name">
                        <span>Featured Project</span>
                        @if($slide['project_url'])
                            <a href="{{ $slide['project_url'] }}">{{ $slide['project_name'] }}</a>
                        @else
                            <strong>{{ $slide['project_name'] }}</strong>
                        @endif
                    </div>
                </article>
            @empty
                <article class="legacy-slide is-active" data-home-slide aria-hidden="false"><img src="{{ asset('assets/images/barqaab-dam.jpg') }}" alt="BARQAAB water infrastructure project"></article>
            @endforelse
        </div>
        <img class="legacy-heading" src="{{ asset('assets/images/barqaab-heading.png') }}" alt="BARQAAB">
        @if($slides->count() > 1)
            <div class="legacy-slide-dots" role="tablist" aria-label="Choose project image">
                @foreach($slides as $slide)
                    <button type="button" class="{{ $loop->first ? 'is-active' : '' }}" role="tab" aria-label="Show project image {{ $loop->iteration }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" data-home-dot="{{ $loop->index }}"></button>
                @endforeach
            </div>
        @endif
    </div>
    <nav class="legacy-nav" aria-label="Main navigation">
        <a class="legacy-mark" href="{{ route('home') }}"><img src="{{ asset('assets/images/barqaab-logo.png') }}" alt="BARQAAB"></a>
        <button type="button" aria-label="Toggle menu" onclick="this.parentElement.classList.toggle('expanded')"><span></span><span></span><span></span></button>
        <div class="legacy-links"><a class="active" href="{{ route('home') }}">Home</a><a href="{{ route('about') }}">About Us</a><a href="{{ route('management') }}">Management</a><a href="{{ route('core-staff') }}">Core Staff</a><a href="{{ route('projects') }}">Projects</a><a href="{{ route('services') }}">Services</a><a href="{{ route('careers') }}">Careers</a><a href="{{ route('contact') }}">Contact Us</a></div>
    </nav>
</section>

<script>
    (() => {
        const slider = document.querySelector('[data-home-slider]');
        const slides = [...slider.querySelectorAll('[data-home-slide]')];
        const dots = [...slider.querySelectorAll('[data-home-dot]')];
        let current = 0;
        let timer;

        const showSlide = (index) => {
            current = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                const active = slideIndex === current;
                slide.classList.toggle('is-active', active);
                slide.setAttribute('aria-hidden', active ? 'false' : 'true');
            });
            dots.forEach((dot, dotIndex) => {
                const active = dotIndex === current;
                dot.classList.toggle('is-active', active);
                dot.setAttribute('aria-selected', active ? 'true' : 'false');
            });
        };

        const stop = () => window.clearInterval(timer);
        const start = () => {
            stop();
            if (slides.length > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                timer = window.setInterval(() => showSlide(current + 1), 5500);
            }
        };

        dots.forEach(dot => dot.addEventListener('click', () => {
            showSlide(Number(dot.dataset.homeDot));
            start();
        }));
        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
        document.addEventListener('visibilitychange', () => document.hidden ? stop() : start());
        start();
    })();
</script>
@endsection
