<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('seo.meta')
    <link rel="stylesheet" href="{{ asset('css/legacy-page.css') }}?v={{ filemtime(public_path('css/legacy-page.css')) }}">
</head>
<body>
<nav class="classic-nav" aria-label="Main navigation">
    <a class="classic-mark" href="{{ route('home') }}"><img src="{{ asset('assets/images/barqaab-logo.png') }}" alt="BARQAAB"></a>
    <button type="button" aria-label="Toggle menu" onclick="this.parentElement.classList.toggle('expanded')"><span></span><span></span><span></span></button>
    <div class="classic-links">
        <a href="{{ route('home') }}">Home</a>
        <div class="classic-dropdown">
            <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
            <div class="classic-submenu" aria-label="About Us sections">
                <a href="{{ route('about') }}#organization-chart">Organization Chart</a>
                <a href="{{ route('about') }}#overview">Overview</a>
                <a href="{{ route('about') }}#registration">Registration</a>
                <a href="{{ route('about') }}#clients">Our Clients</a>
            </div>
        </div>
        <a class="{{ request()->routeIs('management') ? 'active' : '' }}" href="{{ route('management') }}">Management</a>
        <a class="{{ request()->routeIs('core-staff') ? 'active' : '' }}" href="{{ route('core-staff') }}">Core Staff</a>
        <a class="{{ request()->routeIs('projects*') ? 'active' : '' }}" href="{{ route('projects') }}">Projects</a>
        <a class="{{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
        <a class="{{ request()->routeIs('careers*') ? 'active' : '' }}" href="{{ route('careers') }}">Careers</a>
        <a class="{{ request()->routeIs('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
    </div>
</nav>
<main>@yield('content')</main>
@include('seo.analytics')
</body>
</html>
