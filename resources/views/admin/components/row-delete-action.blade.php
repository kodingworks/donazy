<x-admin::row-action href="#" x-data="" x-on:click="$refs.submit.click()">
    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
    </svg>
    <form action="{{ $attributes->get('href') }}" method="POST"
        onsubmit="return confirm('Apakah anda yakin untuk menghapus?')">
        @csrf
        @method('DELETE')
        <input type="submit" class="hidden" x-ref="submit" />
    </form>
</x-admin::row-action>
