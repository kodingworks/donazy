@props(['campaign'])

<a href="{{ route('campaigns.show', ['slug' => $campaign->slug]) }}" class="block shadow-md rounded-3xl overflow-hidden relative">
    @if ($campaign->canClose() && $campaign->isClosed())
        <div class="absolute inset-0 flex items-center justify-center bg-primary bg-opacity-30">
            <div class="px-3 py-2 rounded text-xl uppercase bg-white text-primary">Ditutup</div>
        </div>
    @endif
    <img class="w-full h-40 object-cover object-center" src="{{ $campaign->thumbnail_cover_url }}" />
    <div class="p-4 border block">
        <h3 class="font-bold mt-2 line-clamp-2">{{ $campaign->name }}</h3>
        <p class="text-gray-500 text-sm mt-2 line-clamp-1">{{ $campaign->name }}</p>
        <div class="h-2 bg-gray-200 rounded my-2 overflow-hidden">
            <div style="width: {{ $campaign->collected_funds_percentage }}" class="h-2 bg-primary"></div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="flex flex-col">
                <p class="text-sm text-gray-400">Donasi Terkumpul</p>
                <p class="font-bold">@idr($campaign->collected_funds)</p>
            </div>
            @if ($campaign->canClose() && !$campaign->isClosed())
                <div class="flex flex-col text-right">
                    <p class="text-sm text-gray-400">Sisa Waktu</p>
                    <p class="font-bold">{{ $campaign->time_left ? "{$campaign->time_left} Hari" : "Hari ini" }}</p>
                </div>
            @endif
        </div>
    </div>
</a>
