<x-mail::message>
<table class="judul"  align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
Verify Your Email Address
</td>
</tr>
</table>
<table class="subcopy"  align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
Before proceeding, please check your email for a verification link.
If you did not receive the email, click the button below:
</td>
</tr>
</table>
<x-mail::button :url="$url">
Verify Email
</x-mail::button>
Or Copy This Link:
<p>
{!! $url !!}
</p>
Thanks,<br>
{{ config('app.name') }}

</x-mail::message>
