<select {!! $attributes->merge(['class' => 'block w-full mt-1 text-sm dark:text-gray-300 rounded border-gray-400 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}>
    {!! $slot !!}
</select>
