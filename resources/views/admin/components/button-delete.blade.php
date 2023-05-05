<div x-data="">
    <form
        action="{{ $attributes->get('action') }}"
        method="POST"
        class="hidden"
        onsubmit="return confirm('Apakah anda yakin untuk menghapus?')"
    >
        @csrf
        @method('DELETE')
        <button type="submit" x-ref="form"></button>
    </form>
    <x-admin::button value="Hapus" x-on:click="$refs.form.click()" />
</div>
