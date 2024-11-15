@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Vertigo Travel Perú')
<img src="{{asset('img/logo.png')}}"  class="logo" alt="Vertigo Travel Perú Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
