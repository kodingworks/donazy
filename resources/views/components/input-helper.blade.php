@props(['value'])

<span {!! $attributes->merge(['class' => 'block text-xs ' . ($attributes->has('error') ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400')]) !!}>{!! $value ?? ($slot ?? null) !!}</span>
