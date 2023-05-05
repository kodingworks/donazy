@props(['value', 'variant' => null])

@switch($variant)
    @case('primary')
        <button {!! $attributes->merge(['class' => 'px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg focus:outline-none bg-primary active:bg-primary focus:shadow-outline-primary']) !!}>
            {!! $value ?? ($slot ?? null) !!}
        </button>
    @break
    @case('secondary')
        <button {!! $attributes->merge(['class' => 'px-4 py-2 text-sm font-medium leading-5 text-primary transition-colors duration-150 border border-primary rounded-lg focus:outline-none bg-transparent active:border-primary focus:shadow-outline-primary']) !!}>
            {!! $value ?? ($slot ?? null) !!}
        </button>
    @break
    @default
        <button {!! $attributes->merge(['class' => 'px-4 py-2 text-sm font-medium leading-5 text-primary transition-colors duration-150 border border-transparent rounded-lg focus:outline-none']) !!}>
            {!! $value ?? ($slot ?? null) !!}
        </button>
@endswitch
