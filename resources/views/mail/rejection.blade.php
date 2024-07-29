@component('mail::message')
# Registration Rejected

Your registration has been rejected.

@component('mail::panel')
Reason: {{ $reason }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent