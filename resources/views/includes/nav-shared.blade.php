@php
    $brandRoute = $brandRoute ?? null;
    $brandText = $brandText ?? config('app.name', 'Navigation');
    $logo = $logo ?? null;
    $links = $links ?? [];
@endphp

<nav class="sticky top-0 z-40 border-b border-gray-200 bg-white/95 backdrop-blur">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[64px] items-center justify-between gap-4 py-2">
            <div class="flex min-w-0 items-center gap-3">
                @if ($logo)
                    <img src="{{ $logo }}" alt="logo" class="h-9 w-9 rounded object-contain">
                @endif

                @if ($brandRoute)
                    <a href="{{ $brandRoute }}" class="truncate text-base font-semibold text-gray-900 hover:text-indigo-600">
                        {{ $brandText }}
                    </a>
                @else
                    <span class="truncate text-base font-semibold text-gray-900">{{ $brandText }}</span>
                @endif
            </div>

            <div class="hidden items-center gap-2 md:flex">
                @foreach ($links as $link)
                    <a
                        href="{{ $link['href'] }}"
                        class="rounded-md px-3 py-2 text-sm transition {{ ($link['active'] ?? false) ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        @if (!empty($links))
            <div class="flex flex-wrap gap-2 pb-3 md:hidden">
                @foreach ($links as $link)
                    <a
                        href="{{ $link['href'] }}"
                        class="rounded-md px-3 py-1.5 text-sm transition {{ ($link['active'] ?? false) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</nav>

