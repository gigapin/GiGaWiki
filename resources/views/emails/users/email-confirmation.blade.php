@component('mail::message')
# {{ config('app.name') }} | Verify your email

Hi {{ $user->name }},   
To get access to your account please confirm your email address clicking the link below.  

@component('mail::button', ['url' => $url])
Verify your email address
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
