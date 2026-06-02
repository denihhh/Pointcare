@php
if (! isset($scrollTo)) {
    $scrollTo = '#top';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView({ behavior: 'smooth', block: 'start' })
    JS
    : '';
@endphp

<div class="mt-6">
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col gap-3 items-center justify-between">

            {{-- MOBILE --}}
            <div class="flex justify-between flex-1 sm:hidden gap-2 w-full">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="px-4 py-2 text-sm text-gray-400 bg-white border rounded-xl">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button
                        type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        class="px-4 py-2 text-sm text-gray-700 bg-white border rounded-xl hover:bg-rose-50 transition"
                    >
                        {!! __('pagination.previous') !!}
                    </button>
                @endif

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <button
                        type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        class="px-4 py-2 text-sm text-gray-700 bg-white border rounded-xl hover:bg-rose-50 transition"
                    >
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="px-4 py-2 text-sm text-gray-400 bg-white border rounded-xl">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>

            {{-- DESKTOP --}}
            <div class="hidden sm:flex sm:items-center sm:justify-between w-full">

                {{-- Info --}}
                <div class="text-sm text-gray-600">
                    Showing
                    <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-semibold">{{ $paginator->total() }}</span>
                    results
                </div>

                {{-- Pagination --}}
                <div class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 bg-white border rounded-xl">
                            ‹
                        </span>
                    @else
                        <button
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="px-3 py-2 bg-white border rounded-xl hover:bg-rose-50 transition"
                        >
                            ‹
                        </button>
                    @endif

                    {{-- Pages --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-3 py-2 text-gray-500">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-4 py-2 bg-rose-600 text-white rounded-xl font-semibold shadow">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                        class="px-4 py-2 bg-white border rounded-xl hover:bg-rose-50 transition"
                                    >
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <button
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="px-3 py-2 bg-white border rounded-xl hover:bg-rose-50 transition"
                        >
                            ›
                        </button>
                    @else
                        <span class="px-3 py-2 text-gray-400 bg-white border rounded-xl">
                            ›
                        </span>
                    @endif

                </div>
            </div>
        </nav>
    @endif
</div>