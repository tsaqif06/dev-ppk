<x-mail::message>
<table class="judul"  align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
Username & Password
</td>
</tr>
</table>
<table class="subcopy"  align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
username : {{ $username }}
</td>
<td>
password : {{ $password }}
</td>
</tr>
</table>
<p></p>
<p class="justify-text">
Dengan menggunakan akun ini, Anda setuju untuk mematuhi semua aturan dan ketentuan yang berlaku. Anda bertanggung jawab penuh atas keamanan dan kerahasiaan informasi login Anda, serta aktivitas yang terjadi di dalam akun Anda. Kami tidak bertanggung jawab atas kerugian atau kerusakan yang timbul akibat penggunaan yang tidak sah dari akun Anda. Kami berhak untuk membatasi, menangguhkan, atau menghentikan akses Anda ke akun ini jika kami mencurigai adanya pelanggaran terhadap kebijakan kami atau aktivitas yang merugikan. Harap selalu menjaga keamanan informasi pribadi Anda dan segera laporkan kepada kami jika terdapat aktivitas mencurigakan
</p>
<p></p>
Terima Kasih,<br>
{{ config('app.name') }}

</x-mail::message>
