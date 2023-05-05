@props(['value'])

<h2 {!! $attributes->merge(['class' => 'my-4 text-lg font-semibold text-gray-600 dark:text-gray-300']) !!}">
    {!! $value ?? $slot ?? null !!}
</h2>
