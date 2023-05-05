<x-admin::app>
    <div class="flex items-center space-x-2">
        <x-admin::back :href="route('admin::campaigns.index')" />
        <x-admin::page-title value="Detail Program" />
    </div>

    <x-admin::card>
        <div class="mb-4">
            <x-admin::label value="Nama" />
            <p class="text-sm">{{ $campaign->name }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Slug" />
            <p class="text-sm">{{ $campaign->slug }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Cover" />
            <img src="{!! $campaign->original_cover_url !!}" class="w-full" />
        </div>
        <div class="mb-4">
            <x-admin::label value="Deskripsi" />
            <p class="text-sm">{!! $campaign->description !!}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Kebutuhan Dana" />
            <p class="text-sm">@if($campaign->isUnlimitedFunds()) @idr($campaign->funds) @else Tidak terbatas @endif</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Dana Terkumpul" />
            <p class="text-sm">@idr($campaign->collected_funds ?? 0)</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Donatur" />
            <p class="text-sm">{{ $campaign->donors ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Waktu Terbit" />
            <p class="text-sm">{{ $campaign->published_at ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Waktu Ditutup" />
            <p class="text-sm">{{ $campaign->closed_at ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Jenis" />
            <p class="text-sm">{{ $campaign->type ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <x-admin::label value="Kode Unik Transaksi Paling Belakang" />
            <p class="text-sm">{{ $campaign->unique_code_sufix ?? '-' }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <x-admin::link variant="primary" :href="route('admin::campaigns.edit', $campaign)" value="Ubah" />
            <x-admin::button-delete :action="route('admin::campaigns.destroy', $campaign)" />
        </div>
    </x-admin::card>
</x-admin::app>
