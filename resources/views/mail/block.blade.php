@component('mail::message')
# Account Blocked

Your Account has been Blocked.

@component('mail::panel')
Reason: {{ $reason }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent