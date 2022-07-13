@component('mail::message')
# Invite to partecipe in {{ config('app.name') }}

Hi {{ $name }},   
You have been invited to partecipate in GiGaWiki web application.  
Click on button below to agree.

@component('mail::button', ['url' => $url])
Agree to invite
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
