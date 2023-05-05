<div class="w-full">
    <div id="{{ $attributes->get('id') }}" class="splide">
        <div class="splide__track">
            <div class="splide__list">
                {!! $slot !!}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Splide("#{{ $attributes->get('id') }}", {
                gap: '1rem',
                pagination: false,
                autoWidth: true,
            }).mount();
        });
    </script>
</div>
