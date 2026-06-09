@if ($paginator->hasPages())
<div style="background:red;color:white;padding:20px;">
    TEST PAGINATION
</div>
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

    {{-- Mobile --}}
    <div class="flex gap-3 items-center justify-between sm:hidden">

        @if ($paginator->onFirstPage())
            <span
                class="flex items-center justify-center px-5 py-3 font-black text-gray-400 bg-gray-200 border-4 border-gray-400 rounded-xl opacity-60 cursor-not-allowed">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
                class="flex items-center justify-center px-5 py-3 font-black text-black bg-cyan-300 border-4 border-black rounded-xl shadow-[5px_5px_0px_#000] hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[8px_8px_0px_#000] transition-all duration-150">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                rel="next"
                class="flex items-center justify-center px-5 py-3 font-black text-black bg-cyan-300 border-4 border-black rounded-xl shadow-[5px_5px_0px_#000] hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[8px_8px_0px_#000] transition-all duration-150">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span
                class="flex items-center justify-center px-5 py-3 font-black text-gray-400 bg-gray-200 border-4 border-gray-400 rounded-xl opacity-60 cursor-not-allowed">
                {!! __('pagination.next') !!}
            </span>
        @endif

    </div>

    {{-- Desktop --}}
    <div class="hidden sm:flex sm:items-center sm:justify-between mt-6">

        {{-- Info --}}
        <div>
            <p class="font-bold text-black">
                Menampilkan
                <span class="font-black">{{ $paginator->firstItem() }}</span>
                -
                <span class="font-black">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-black">{{ $paginator->total() }}</span>
                data
            </p>
        </div>

        {{-- Pagination --}}
        <div>

            <span class="flex items-center gap-3">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())

                    <span
                        class="flex items-center justify-center w-12 h-12 bg-gray-200 border-4 border-gray-400 rounded-xl opacity-60 cursor-not-allowed">

                        <svg class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>

                    </span>

                @else

                    <a href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        class="flex items-center justify-center w-12 h-12 bg-cyan-300 border-4 border-black rounded-xl shadow-[5px_5px_0px_#000] hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[8px_8px_0px_#000] transition-all duration-150">

                        <svg class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>

                    </a>

                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)

                    @if (is_string($element))

                        <span
                            class="flex items-center justify-center w-12 h-12 bg-white border-4 border-black rounded-xl font-black shadow-[5px_5px_0px_#000]">
                            {{ $element }}
                        </span>

                    @endif

                    @if (is_array($element))

                        @foreach ($element as $page => $url)

                            @if ($page == $paginator->currentPage())

                                <span
                                    class="flex items-center justify-center w-12 h-12 bg-lime-400 border-4 border-black rounded-xl font-black shadow-[5px_5px_0px_#000]">

                                    {{ $page }}

                                </span>

                            @else

                                <a href="{{ $url }}"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                    class="flex items-center justify-center w-12 h-12 bg-white border-4 border-black rounded-xl font-black shadow-[5px_5px_0px_#000] hover:bg-yellow-300 hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[8px_8px_0px_#000] transition-all duration-150">

                                    {{ $page }}

                                </a>

                            @endif

                        @endforeach

                    @endif

                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())

                    <a href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        class="flex items-center justify-center w-12 h-12 bg-cyan-300 border-4 border-black rounded-xl shadow-[5px_5px_0px_#000] hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[8px_8px_0px_#000] transition-all duration-150">

                        <svg class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>

                    </a>

                @else

                    <span
                        class="flex items-center justify-center w-12 h-12 bg-gray-200 border-4 border-gray-400 rounded-xl opacity-60 cursor-not-allowed">

                        <svg class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>

                    </span>

                @endif

            </span>

        </div>

    </div>

</nav>
@endif