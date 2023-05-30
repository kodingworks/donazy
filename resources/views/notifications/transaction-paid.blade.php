@component('mail::message')
Bismillah

Jazaakumulllahu khairan **{{ $transaction->user_name }}** atas donasi anda sebesar **@idr($transaction->total)** untuk program **{{ $transaction->campaign->name }}**.

Semoga donasi dan dukungan yang anda berikan menjadi amal ibadah yang diterima disisi Allah Subhanahu Wa Ta’ala.

Aamiin Allahumma Aamiin.

*Ingin mendaftar menjadi Donatur Tetap?*<br />
<a href="#" style="color: #23925C">Hubungi Kami</a>

<p style="color: #23925C; font-weight: bold">{{ Config::get('app.name') }}</p>
<img src="{{ asset('https://i.ibb.co/F7K52H7/donazy-logo-rounded.png') }}" width="100" />

@endcomponent

