@props(['value', 'required' => false])

<span {!! $attributes->merge(['class' => 'text-gray-700 dark:text-gray-400 text-sm']) !!}>
    {!! $value ?? $slot ?? null !!} @if ($required) <span class="text-red-600">*</span> @endif
</span>
