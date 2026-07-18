@extends('layouts.legacy-page')
@section('title', 'BARQAAB | ABOUT US')
@section('content')
<section class="about-page">
    <header class="about-hero">
        <div class="about-hero-copy">
            <p class="about-eyebrow">{{ $about->eyebrow }}</p>
            <h1>{{ Str::upper($about->title) }}</h1>
            <p class="about-lead">{{ $about->hero_text }}</p>
        </div>
        <div class="about-mark">
            <span>Water. Power. Progress.</span>
            <img src="{{ asset('assets/images/barqaab-about-logo.jpg') }}" alt="BARQAAB Consulting Services logo">
        </div>
    </header>

    @if($about->highlights)
        <div class="about-highlights" aria-label="Company highlights">
            @foreach($about->highlights as $highlight)
                <article><strong>{{ $highlight['value'] ?? '' }}</strong><span>{{ $highlight['label'] ?? '' }}</span></article>
            @endforeach
        </div>
    @endif

    <section class="about-story" id="overview">
        <header>
            <p>Overview</p>
            <h2>{{ $about->overview_heading }}</h2>
        </header>
        <div class="about-story-copy about-rich-copy">{!! $about->overview_body !!}</div>
    </section>

    <section class="about-organization" id="organization-chart">
        <header class="about-section-heading">
            <p>Organization Chart</p>
            <h2>{{ $about->organization_heading }}</h2>
            @if($about->organization_intro)<div>{{ $about->organization_intro }}</div>@endif
        </header>
        <div class="organization-chart">
            @foreach($about->organization_units ?? [] as $unit)
                <article>
                    <h3>{{ $unit['title'] ?? '' }}</h3>
                    <ul>
                        @foreach(preg_split('/\r\n|\r|\n/', $unit['details'] ?? '') as $detail)
                            @if(trim($detail) !== '')<li>{{ $detail }}</li>@endif
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </section>

    <section class="about-registration" id="registration">
        <header class="about-section-heading">
            <p>Registration</p>
            <h2>Registered and certified to deliver</h2>
        </header>
        <div class="registration-grid">
            @foreach($about->registrations ?? [] as $registration)
                <article>
                    <span>{{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $registration['title'] ?? '' }}</h3>
                    @if($registration['number'] ?? null)<strong>{{ $registration['number'] }}</strong>@endif
                    @if($registration['details'] ?? null)<p>{{ $registration['details'] }}</p>@endif
                </article>
            @endforeach
        </div>
    </section>

    <section class="about-clients" id="clients">
        <header class="about-section-heading">
            <p>Our Clients</p>
            <h2>Organizations that trust BARQAAB</h2>
            @if($about->clients_intro)<div>{{ $about->clients_intro }}</div>@endif
        </header>
        <div class="clients-grid">
            @foreach($about->clients ?? [] as $client)
                @php($clientUrl = $client['website'] ?? null)
                <{{ $clientUrl ? 'a' : 'article' }} class="client-card" @if($clientUrl) href="{{ $clientUrl }}" target="_blank" rel="noopener" @endif>
                    @if($client['logo'] ?? null)
                        <img src="{{ $about->mediaUrl($client['logo']) }}" alt="{{ $client['name'] ?? 'Client' }} logo">
                    @else
                        <span>{{ Str::upper(Str::substr($client['name'] ?? '', 0, 2)) }}</span>
                    @endif
                    <strong>{{ $client['name'] ?? '' }}</strong>
                </{{ $clientUrl ? 'a' : 'article' }}>
            @endforeach
        </div>
    </section>

    <section class="about-expertise">
        <div>
            <p class="about-section-label">What We Deliver</p>
            <h2>{{ $about->expertise_heading }}</h2>
            <div class="about-rich-copy">{!! $about->expertise_body !!}</div>
        </div>
        <aside class="about-certification">
            <span>Certified Management Systems</span>
            <h2>ISO</h2>
            <ul>
                <li><strong>9001:2015</strong> Quality Management</li>
                <li><strong>14001:2015</strong> Environmental Management</li>
                <li><strong>45001:2018</strong> Occupational Health &amp; Safety</li>
            </ul>
            <p>All BARQAAB offices are certified.</p>
        </aside>
    </section>
</section>

<button
    type="button"
    class="about-go-top"
    aria-label="Go to top of About Us page"
    title="Go to top"
    data-about-go-top
>
    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none">
        <path d="M12 19V5M6.5 10.5 12 5l5.5 5.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span>Top</span>
</button>

<script>
    (() => {
        const button = document.querySelector('[data-about-go-top]');
        if (!button) return;

        const updateVisibility = () => {
            button.classList.toggle('is-visible', window.scrollY > 500);
        };

        button.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
            });
        });

        window.addEventListener('scroll', updateVisibility, { passive: true });
        updateVisibility();
    })();
</script>
@endsection
