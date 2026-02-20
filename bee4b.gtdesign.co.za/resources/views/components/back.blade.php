@props([
    'link' => './',
    'title' => '',
])

<div>
    <div class="grid grid-cols-2 text-indigo-600 w-full items-center">
        <a href="{{ $link }}" class="flex justify-start items-center cursor-pointer gap-1 hover:underline">
            <x-icons.left-arrow />
            <span class="font-bold text-lg">Back to {{ $slot }}</span>
        </a>
        <span class="back-title text-xl font-bold text-black max-w-max -translate-x-1/2">{{ $title }}</span>
    </div>
</div>