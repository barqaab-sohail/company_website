@extends('layouts.legacy-page')
@section('title', 'BARQAAB | MANAGEMENT')
@section('content')
<article class="management-page">
    <h1>MANAGEMENT</h1>

    @foreach($members as $member)<section class="manager-profile"><div class="manager-copy"><h2>{{ $member->designation }}</h2><p><strong>{{ $member->name }}</strong></p>@foreach(preg_split('/\r\n|\r|\n/', $member->qualifications ?? '') as $qualification)<p><em>{{ $qualification }}</em></p>@endforeach<div>{!! $member->biography !!}</div></div>@if($member->photo)<img src="{{ $member->photo_url }}" alt="{{ $member->name }}, {{ $member->designation }}">@endif</section>@endforeach
</article>
@endsection
