@extends('layouts.legacy-page')
@section('title', 'BARQAAB | '.$project->title)
@section('content')
<article class="project-page">
    <h1>{{ $project->title }}</h1>
    @if($project->excerpt)<h2>{{ $project->excerpt }}</h2>@endif
    <div class="project-body">{!! $project->body !!}</div>
    @if($project->images->count() > 1)
        <section class="project-gallery"><h3>Project Gallery</h3><div>@foreach($project->images as $image)<figure><img src="{{ $image->url }}" alt="{{ $image->alt_text ?: $project->title }}">@if($image->caption)<figcaption>{{ $image->caption }}</figcaption>@endif</figure>@endforeach</div></section>
    @endif
    @if($project->scope_of_project || $project->scope_of_services)
        <div class="project-scopes">
            @if($project->scope_of_project)<section><h3>Scope of the Project</h3><div>{!! nl2br(e($project->scope_of_project)) !!}</div></section>@endif
            @if($project->scope_of_services)<section><h3>Scope of Services</h3><div>{!! nl2br(e($project->scope_of_services)) !!}</div></section>@endif
        </div>
    @endif
</article>
@endsection
