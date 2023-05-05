@props(['label', 'name', 'value'])

<label class="inline-flex items-center text-gray-600 dark:text-gray-400 mr-4">
    <input type="radio" name="{{ $name }}" value="{{ $value }}"
        class="text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
    <span class="ml-2">{!! $label !!}</span>
</label>
