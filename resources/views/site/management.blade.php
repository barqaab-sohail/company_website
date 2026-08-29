@extends('layouts.legacy-page')
@section('title', 'BARQAAB | MANAGEMENT')
@section('content')
<section class="management-page">
    <header class="management-header">
        <div>
            <p class="management-eyebrow">Executive Leadership</p>
            <h1>MANAGEMENT</h1>
            <p class="management-intro">BARQAAB is led by accomplished professionals whose technical knowledge, institutional experience and strategic direction guide the company&rsquo;s work across Pakistan.</p>
        </div>
        <span class="management-count"><strong>{{ $members->count() }}</strong> Leadership Profiles</span>
    </header>

    <div class="management-list">
        @forelse($members as $member)
            <article class="manager-profile">
                <div class="manager-photo">
                    @if($member->photo)
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}, {{ $member->designation }}" loading="lazy" decoding="async">
                    @else
                        <span aria-hidden="true">{{ Str::upper(Str::substr($member->name, 0, 1)) }}</span>
                    @endif
                </div>

                <div class="manager-copy">
                    <p class="manager-role">{{ $member->designation }}</p>
                    <h2>{{ $member->name }}</h2>

                    @php($qualifications = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $member->qualifications ?? ''))))
                    @if($qualifications)
                        <section class="manager-qualifications">
                            <h3>Qualifications</h3>
                            <ul>@foreach($qualifications as $qualification)<li>{{ $qualification }}</li>@endforeach</ul>
                        </section>
                    @endif

                    @if($member->biography)
                        <div class="manager-biography">{!! $member->biography !!}</div>
                    @endif
                </div>
            </article>
        @empty
            <p class="management-empty">Management profiles will be published shortly.</p>
        @endforelse
    </div>
</section>
@endsection
