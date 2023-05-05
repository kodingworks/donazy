@props(['value', 'name'])

@php
    $url = url()->current();

    if (request('sort') != $name) {
        $url .= "?sort={$name}&direction=asc";
    } else {
        if (request('direction') == 'asc') {
            $url .= "?sort={$name}&direction=desc";
        } else {
            $url .= "?sort={$name}&direction=asc";
        }
    }
@endphp

<a href="{!! $url !!}" class="flex items-center space-x-1">
    <span>{!! $value ?? ($slot ?? null) !!}</span>
    @if (request('sort') == $name && request('direction') == 'asc')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    @elseif (request('sort') == $name && request('direction') == 'desc')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    @endif
</a>
