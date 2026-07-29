@extends('layouts.legacy-page')
@section('title', 'BARQAAB | Contact Us')
@section('content')
<section class="contact-page">
    <h1>Contact Us</h1>
    <div class="contact-rule"></div>
    @if($contact->map_embed_url)
        <div class="contact-map">
            <iframe title="{{ $contact->office_heading ?: 'Head Office' }} location" src="{{ $contact->map_embed_url }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    @endif
    @if(session('success'))<div class="contact-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="contact-errors"><strong>Please correct the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="contact-columns">
        <section>
            <h2>{{ $contact->email_heading ?: 'Email Us' }}</h2>
            <form class="contact-form" method="post" action="{{ route('contact.submit') }}">@csrf
                <label>Your Name (required)<input type="text" name="name" value="{{ old('name') }}" required></label>
                <label>Your Email (required)<input type="email" name="email" value="{{ old('email') }}" required></label>
                <label>Subject (required)<input type="text" name="subject" value="{{ old('subject') }}" required></label>
                <label>Your Message<textarea name="message" required>{{ old('message') }}</textarea></label>
                <button type="submit">Send</button>
            </form>
        </section>
        <aside class="head-office">
            <h2>{{ $contact->office_heading ?: 'Head Office' }}</h2>
            <img src="{{ $contact->logo_url }}" alt="{{ $contact->company_name ?: 'BARQAAB' }}">
            @if($contact->company_name)<p><strong>{{ $contact->company_name }}</strong></p>@endif
            @if($contact->address)<p>{!! nl2br(e($contact->address)) !!}</p>@endif
            <dl>
                @if($contact->phone)<dt>Phone:</dt><dd>{{ $contact->phone }}</dd>@endif
                @if($contact->fax)<dt>Fax:</dt><dd>{{ $contact->fax }}</dd>@endif
                @if($contact->public_email)<dt>Email:</dt><dd><a href="mailto:{{ $contact->public_email }}">{{ $contact->public_email }}</a></dd>@endif
            </dl>
        </aside>
    </div>
</section>
@endsection
