<x-mail::message>
<table class="judul" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
Your link for data update
</td>
</tr>
</table>
<table class="subcopy" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
Before proceeding, please check your email for a link to update your data.
If the link has expired, click the button below to request a new link on your profile page:
</td>
</tr>
</table>
<x-mail::button :url="$url">
Update
</x-mail::button>
Or Copy This Link:
<p>
{!! $url !!}
</p>
Thanks,<br>
{{ config('app.name') }}

</x-mail::message>
