@props(['message', 'type'])

@switch($type)
    @case('success')
        <div
            class="flex items-center space-x-2 p-4 mb-4 text-sm font-semibold text-white rounded-lg shadow-md focus:outline-none bg-primary focus:shadow-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>{!! $message ?? ($slot ?? null) !!}</div>
        </div>
    @break
    @case('error')
        <div
            class="flex items-center space-x-2 p-4 mb-4 text-sm font-semibold text-white rounded-lg shadow-md focus:outline-none bg-red-500 focus:shadow-outline-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>{!! $message ?? ($slot ?? null) !!}</div>
        </div>
    @break
@endswitch
