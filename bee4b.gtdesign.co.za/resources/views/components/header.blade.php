@props([
    'breadcrumbs' => []
])

<div class="flex items-start justify-between pb-4 space-y-4 lg:items-center lg:space-y-0 lg:flex-row">
    <div class="w-full text-2xl font-semibold whitespace-nowrap flex justify-between items-center">
        @isset($title)
        <span class="mr-4">{{ $title ?? '' }}</span>
        @endisset
        <div class="flex flex-row items-center justify-start space-x-2">
            @foreach($breadcrumbs as $index => $bc)
            <span class="flex flex-row items-center justify-start space-x-2">
                @if($index != 0)
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <polyline points="9 6 15 12 9 18"></polyline>
                </svg>
                @endif

                @if($index != count($breadcrumbs)-1)
                <a 
                    class="text-blue-700 hover:underline"
                    href="../{{ lcfirst($bc) }}"
                    >
                    {{ $bc }}
                </a>
                @else
                <span class="font-bold">{{ $bc }}</span>
                @endif
            </span>
            @endforeach
        </div>
        {{ $button ?? '' }}
    </div>
</div>