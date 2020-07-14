@component('mail::message')
# Daily Weather
<br>
{{ $city }} Temp: {{ $temp }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
