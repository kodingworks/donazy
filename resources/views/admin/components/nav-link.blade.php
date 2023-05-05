@props(['label', 'url'])

<li class="relative px-6 py-3">
    @if ($attributes->get('active') === true)
        <span class="absolute inset-y-0 left-0 w-1 bg-primary rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-100 {{ $attributes->get('active') === true ? 'text-gray-800 dark:text-gray-100' : null }}"
        href="{{ $url }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
          </svg>
        <span class="ml-4">{{ $label }}</span>
    </a>
</li>
