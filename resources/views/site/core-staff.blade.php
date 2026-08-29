@extends('layouts.legacy-page')
@section('title', 'BARQAAB | CORE STAFF')
@section('content')
<section class="core-staff-page">
    <header class="core-staff-header">
        <p>Our Leadership</p>
        <h1>CORE STAFF</h1>
        <div>Experienced professionals providing technical leadership across BARQAAB&rsquo;s water, power and infrastructure assignments.</div>
    </header>

    <div class="core-staff-grid">
        @forelse($members as $member)
            <article class="core-staff-card">
                <div class="core-staff-photo">
                    @if($member->photo)
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}, {{ $member->designation }}" loading="lazy" decoding="async">
                    @else
                        <span aria-hidden="true">{{ Str::upper(Str::substr($member->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="core-staff-details">
                    @if($member->years_experience)<p class="core-staff-experience">{{ $member->years_experience }} of experience</p>@endif
                    <h2>{{ $member->name }}</h2>
                    <p class="core-staff-designation">{{ $member->designation }}</p>

                    @if($member->qualifications)
                        <section class="core-staff-qualifications">
                            <h3>Qualifications</h3>
                            <ul>
                                @foreach(preg_split('/\r\n|\r|\n/', $member->qualifications) as $qualification)
                                    @if(trim($qualification) !== '')<li>{{ $qualification }}</li>@endif
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    @if($member->expertise_summary)
                        <section class="core-staff-expertise">
                            <h3>Expertise</h3>
                            <p>{{ $member->expertise_summary }}</p>
                        </section>
                    @endif
                </div>
            </article>
        @empty
            <p class="core-staff-empty">Core staff profiles will be published shortly.</p>
        @endforelse
    </div>
</section>
@endsection
