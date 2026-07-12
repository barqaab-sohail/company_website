@extends('layouts.site')
@section('title', 'BARQAAB')
@section('content')
<section class="legacy-home" aria-label="BARQAAB home">
    <div class="legacy-hero"><img class="legacy-heading" src="{{ asset('assets/images/barqaab-heading.png') }}" alt="BARQAAB"></div>
    <nav class="legacy-nav" aria-label="Main navigation">
        <a class="legacy-mark" href="{{ route('home') }}"><img src="{{ asset('assets/images/barqaab-logo.png') }}" alt="BARQAAB"></a>
        <button type="button" aria-label="Toggle menu" onclick="this.parentElement.classList.toggle('expanded')"><span></span><span></span><span></span></button>
        <div class="legacy-links"><a class="active" href="{{ route('home') }}">Home</a><a href="{{ route('about') }}">About Us</a><a href="{{ route('management') }}">Management</a><a href="{{ route('projects') }}">Projects</a><a href="{{ route('services') }}">Services</a><a href="{{ route('careers') }}">Careers</a><a href="{{ route('contact') }}">Contact Us</a></div>
    </nav>
</section>
@endsection
