@props(['label', 'url'])

<li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
    <a class="w-full" href="{{ $url }}">{{ $label }}</a>
</li>
