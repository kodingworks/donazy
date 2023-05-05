@props(['disabled' => false, 'error' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm ' . ($error ? 'border-red-600 focus:border-red-400 focus:shadow-outline-red' : 'border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50')]) !!}>
