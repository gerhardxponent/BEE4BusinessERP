@props(['active' => null, 'colour' => 'lime'])

@php
$classes = ($active)
            ? "flex items-center h-10 px-3 text-white bg-b4bgreen-normal rounded-lg transition-colors duration-150 ease-in-out focus:outline-none focus:shadow-outline"
            : "flex items-center h-10 px-3 hover:bg-b4bgreen-normal hover:bg-opacity-25 rounded-lg transition-colors duration-150 ease-in-out focus:outline-none focus:shadow-outline";
@endphp

<a 
    href="{{ $route }}"
    {{ $attributes->merge(['class' => $classes]) }}
    >
    {{-- <svg viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 flex-shrink-0">
        <path
            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
    </svg> --}}
    <span class="module-icon">
        {{ $icon }}
    </span>
    <span 
        class="ml-2 duration-300 ease-in-out"
        :class="isSidebarExpanded ? 'opacity-100' : 'opacity-0'"
    >
        {{ $name }}
    </span>
</a>