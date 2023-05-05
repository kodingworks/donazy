@props(['value'])

<textarea {!! $attributes->merge(['class' => 'block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}>{!! $value ?? $slot ?? null !!}</textarea>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        CKEDITOR.replace("{{ $attributes->get('id') }}", {
            height: 700,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
            removePlugins: 'about,a11yhelp,scayt,uploadimage',
            removeDialogTabs: 'image:Upload;image:advanced',
        });
    });
</script>
