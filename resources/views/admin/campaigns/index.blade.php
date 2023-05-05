<x-admin::app>
    <x-admin::page-title value="Program" />

    <x-admin::success-alert />

    <div class="flex justify-between items-center space-x-2 rounded-lg mb-4">
        <div>
            <form action="{{ route('admin::campaigns.index') }}" method="GET">
                <x-admin::search />
            </form>
        </div>
        <div>
            <x-admin::link
                variant="primary"
                :href="route('admin::campaigns.create')"
                value="Buat"
                class="mt-1"
            />
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-md">
        <x-admin::table>
            <thead>
                <x-admin::col-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="ID" name="id" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Nama" name="name" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Slug" name="slug" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Kebutuhan Dana" name="funds" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Dana Terkumpul" name="collected_funds" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Waktu Terbit" name="published_at" />
                    </x-admin::row-header>
                    <x-admin::row-header>
                        <x-admin::sortable value="Waktu Ditutup" name="closed_at" />
                    </x-admin::row-header>
                    <x-admin::row-header>Aksi</x-admin::row-header>
                </x-admin::col-header>
            </thead>
            <x-admin::tbody>
                @forelse ($campaigns as $campaign)
                    <x-admin::col>
                        <x-admin::row>{{ $campaign->id }}</x-admin::row>
                        <x-admin::row>{{ $campaign->name }}</x-admin::row>
                        <x-admin::row>{{ $campaign->slug }}</x-admin::row>
                        <x-admin::row>@if($campaign->isUnlimitedFunds()) @idr($campaign->funds) @else Tidak terbatas @endif</x-admin::row>
                        <x-admin::row>@idr($campaign->collected_funds)</x-admin::row>
                        <x-admin::row>{{ $campaign->published_at }}</x-admin::row>
                        <x-admin::row>{{ $campaign->closed_at }}</x-admin::row>
                        <x-admin::row>
                            <div class="flex items-center text-sm">
                                <x-admin::row-show-action :href="route('admin::campaigns.show', $campaign)" />
                                <x-admin::row-edit-action :href="route('admin::campaigns.edit', $campaign)" />
                                <x-admin::row-delete-action :href="route('admin::campaigns.destroy', $campaign)" />
                            </div>
                        </x-admin::row>
                    </x-admin::col>
                @empty
                    <x-admin::col>
                        <x-admin::row colspan="8">
                            <x-admin::empty />
                        </x-admin::row>
                    </x-admin::col>
                @endforelse
            </x-admin::tbody>
        </x-admin::table>
        <x-admin::pagination :collection="$campaigns" />
    </div>
</x-admin::app>
