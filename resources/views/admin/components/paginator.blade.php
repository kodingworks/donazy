@if ($paginator->hasPages())
    <div
        class="flex flex-col md:flex-row justify-between items-center px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
        <div class="text-left">
            Menampilkan
            <span>{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</span>
            dari
            <span>{{ $paginator->total() }}</span>
        </div>
        <!-- Pagination -->
        <div class="flex mt-2 md:mt-0 ml-auto">
            <nav aria-label="Table navigation">
                <ul class="inline-flex items-center">
                    <li>
                        <a href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() }}"
                            class="block px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-primary"
                            aria-label="Previous">
                            <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-3 py-1">{{ "{$paginator->currentPage()}/{$paginator->lastPage()}" }}</a>
                    </li>
                    <li>
                        <a href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}"
                            class="block px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-primary"
                            aria-label="Next">
                            <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                <path
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endif
