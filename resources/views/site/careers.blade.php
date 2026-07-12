@extends('layouts.legacy-page')
@section('title', 'BARQAAB | Submit CV')
@section('content')
<section class="career-page">
    <h1>Submit CV</h1>
    <p class="required-note">* Required</p>
    @if(session('success'))<div class="career-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="career-errors"><strong>Please correct the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="post" action="{{ route('careers.submit') }}" enctype="multipart/form-data" class="career-form">@csrf
        <label><span>First Name:<b>*</b></span><input name="first_name" value="{{ old('first_name') }}" required></label>
        <label><span>Last Name:<b>*</b></span><input name="last_name" value="{{ old('last_name') }}" required></label>
        <label><span>Address:<b>*</b></span><input name="address" value="{{ old('address') }}" required></label>
        <label><span>City:<b>*</b></span><input name="city" value="{{ old('city') }}" required></label>
        <div class="career-phone"><label><span>Primary Contact Number:<b>*</b></span><input name="phone" value="{{ old('phone') }}" required></label><div class="contact-types">@foreach(['home'=>'Home','mobile'=>'Mobile','work'=>'Work','other'=>'Other'] as $value=>$label)<label><input type="radio" name="contact_type" value="{{ $value }}" @checked(old('contact_type')===$value) required>{{ $label }}</label>@endforeach</div></div>
        <label><span>E-Mail Address:<b>*</b></span><input type="email" name="email" value="{{ old('email') }}" required></label>
        <label><span>Regarding Job:<b>*</b></span><select name="regarding_job" required><option value="" @selected(!old('regarding_job'))></option><option value="general" @selected(old('regarding_job')==='general')>General Purpose</option>@foreach($jobs as $job)<option value="{{ $job->id }}" @selected((string)old('regarding_job')===(string)$job->id)>{{ $job->title }}@if($job->location) — {{ $job->location }}@endif</option>@endforeach</select></label>

        <fieldset class="education-fieldset"><legend>Education:<b>*</b></legend><div id="education-rows">@foreach(old('education',[['qualification'=>'','year'=>'']]) as $index=>$education)<div class="education-row"><input name="education[{{ $index }}][qualification]" value="{{ $education['qualification'] ?? '' }}" placeholder="Qualification, e.g. B.S (Electrical)" required><input type="number" name="education[{{ $index }}][year]" value="{{ $education['year'] ?? '' }}" placeholder="Completion year" min="1940" max="{{ date('Y') }}" required><button type="button" class="remove-education" aria-label="Remove education">×</button></div>@endforeach</div><button type="button" id="add-education">+ Add Education</button></fieldset>
        <label><span>Total Experience:<b>*</b></span><div class="experience-input"><input type="number" name="total_experience" value="{{ old('total_experience') }}" min="0" max="80" step="0.5" required><small>Years</small></div></label>
        <label><span>Attachment(s):<b>*</b></span><div><input type="file" name="resume" accept=".pdf,.doc,.docx" required><small class="file-help">Allowed extensions: pdf, doc, docx — maximum 10 MB</small></div></label>
        <button class="resume-submit" type="submit">Submit Resume</button>
    </form>
</section>
<script>
const educationRows=document.getElementById('education-rows');
function bindRemove(){document.querySelectorAll('.remove-education').forEach(button=>button.onclick=()=>{if(educationRows.children.length>1)button.closest('.education-row').remove()})}
document.getElementById('add-education').onclick=()=>{const index=Date.now();educationRows.insertAdjacentHTML('beforeend',`<div class="education-row"><input name="education[${index}][qualification]" placeholder="Qualification, e.g. M.Sc (Electrical)" required><input type="number" name="education[${index}][year]" placeholder="Completion year" min="1940" max="{{ date('Y') }}" required><button type="button" class="remove-education" aria-label="Remove education">×</button></div>`);bindRemove()};bindRemove();
</script>
@endsection
