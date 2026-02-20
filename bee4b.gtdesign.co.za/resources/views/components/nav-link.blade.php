@props(['active', 'colour' => 'lime'])

@php
$classes = ($active ?? false)
            ? "link flex items-center relative p-2 space-x-2 rounded-md bg-indigo-400"
            : "link flex items-center relative p-2 space-x-2 rounded-md hover:bg-gray-100";
@endphp

<style>
    .module-name {
        left: 114%;
        opacity: 0;
        transform: scaleX(0);
        transition: opacity 0.3s ease-in-out;
    }
</style>

<a
    @if($active)
        style="background-color:#9DC43A; color:black;"
    @endif
    href="{{ $route }}"
    {{ $attributes->merge(['class' => $classes]) }}
    :class="{'justify-center': !isSidebarOpen}">

    <span class="module-icon">
        {{ $icon }}
    </span>
    
    <!-- <span 
        :class="{'module-name absolute bg-violet-100 z-100 text-black px-2 py-1 rounded-md font-bold' : !isSidebarOpen, 'hidden' : isSidebarOpen}"
        style="background-color:#9DC43A">
        {{ $name }}
    </span>

    <span :class="{ 'lg:hidden': !isSidebarOpen }">{{ $name }}</span> -->

    <div class="hidden bg-lime-400"></div>
</a>