@props(['label', 'name', 'value', 'checked' => false])

<label class="flex items-center dark:text-gray-400 mr-4 mt-1">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($checked == true)
        checked
        @endif
        class="text-primary focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray" />
    <span class="ml-2">{!! $label ?? ($slot ?? null) !!}</span>
</label>
