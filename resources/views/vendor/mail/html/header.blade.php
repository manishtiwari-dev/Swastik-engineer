@props(['url'])
<tr>
<td class="header">
{{-- <a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a> --}}

<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ uploadedAsset(getSetting('navbar_logo')) }}"  onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';"  alt="{{getSetting('system_title')}}">
</a>

</td>
</tr>
