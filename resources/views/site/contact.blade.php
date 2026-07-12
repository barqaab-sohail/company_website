@extends('layouts.legacy-page')
@section('title', 'BARQAAB | Contact Us')
@section('content')
<section class="contact-page">
    <h1>Contact Us</h1>
    <div class="contact-rule"></div>
    <div class="contact-map"><iframe title="BARQAAB Head Office location" src="https://www.google.com/maps?q=BARQAAB%20Consulting%20Services%20Sunny%20View%20Estate%20Kashmir%20Road%20Lahore&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
    @if(session('success'))<div class="contact-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="contact-errors"><strong>Please correct the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="contact-columns">
        <section>
            <h2>Email Us</h2>
            <form class="contact-form" method="post" action="{{ route('contact.submit') }}">@csrf
                <label>Your Name (required)<input type="text" name="name" value="{{ old('name') }}" required></label>
                <label>Your Email (required)<input type="email" name="email" value="{{ old('email') }}" required></label>
                <label>Subject (required)<input type="text" name="subject" value="{{ old('subject') }}" required></label>
                <label>Your Message<textarea name="message" required>{{ old('message') }}</textarea></label>
                <button type="submit">Send</button>
            </form>
        </section>
        <aside class="head-office">
            <h2>Head Office</h2>
            <img src="{{ asset('assets/images/contact-barqaab-logo.png') }}" alt="BARQAAB">
            <p><strong>BARQAAB Consulting Services</strong></p>
            <p>Sunny View Estate, Kashmir Road,<br>Lahore – Pakistan.</p>
            <dl><dt>Phone:</dt><dd><a href="tel:+924299202093">+92-042-99202093-94, 99203384</a></dd><dt>Fax:</dt><dd>+92-042-99202095</dd><dt>Email:</dt><dd><a href="mailto:info@barqaab.com">info@barqaab.com</a></dd></dl>
        </aside>
    </div>
</section>
@endsection
