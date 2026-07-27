<!doctype html>
<html lang="en">
<body style="margin:0;padding:24px;background:#f3f5f7;color:#1f2933;font-family:Arial,sans-serif">
<div style="max-width:680px;margin:auto;padding:28px;background:#fff;border-top:5px solid #1e6eab">
    <h1 style="margin:0 0 22px;font-size:24px">New website inquiry</h1>
    <p><strong>Name:</strong> {{ $inquiry->name }}</p>
    <p><strong>Email:</strong> <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></p>
    @if($inquiry->phone)<p><strong>Phone:</strong> {{ $inquiry->phone }}</p>@endif
    <p><strong>Subject:</strong> {{ $inquiry->subject }}</p>
    <div style="margin-top:22px;padding:18px;background:#f5f7f9;border-left:3px solid #ef7f29;white-space:pre-wrap">{{ $inquiry->message }}</div>
    <p style="margin-top:24px;color:#687782;font-size:12px">Received {{ $inquiry->created_at->format('d M Y, h:i A') }} from {{ $inquiry->source_ip }}</p>
</div>
</body>
</html>
