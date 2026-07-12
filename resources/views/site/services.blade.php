@extends('layouts.legacy-page')
@section('title', 'BARQAAB | SERVICES')
@section('content')
<section class="services-page">
    <h1>SERVICES</h1>
    <div class="services-grid">
        @foreach($services as $index => $service)
            @if($index === 3 || $index === 6)<div class="services-divider" aria-hidden="true"></div>@endif
            <article class="service-card">
                <h2>{{ Str::upper($service->title) }}</h2>
                @if($service->image)<img src="{{ $service->image_url }}" alt="{{ $service->title }}">@endif
                @if($service->description)<p>{{ $service->description }}</p>@endif
                <ul>@foreach($service->items ?? [] as $item)<li>{{ $item }}</li>@endforeach</ul>
            </article>
        @endforeach
    </div>
</section>
@endsection
