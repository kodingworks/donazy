@props(['href' => 'javascript:history.go(-1)'])

<a href="{!! $href !!}" class="block px-3 py-2 text-gray-500 hover:text-primary focus:text-primary">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
    </svg>
</a>
