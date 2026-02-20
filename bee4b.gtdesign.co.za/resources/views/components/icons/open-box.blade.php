@props([
    'width' => '24',
    'height' => '24',
    'size' => null
])

<svg width="{{ isset($size) ? $size : $width }}" height="{{ isset($size) ? $size : $height }}" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 5 6 9l6 4 6-4-6-4Z"></path>
    <path d="m12 5 6 4 2.5-3.5L15 2l-3 3Z"></path>
    <path d="M12 5 6 9 3.5 5.5 9 2l3 3Z"></path>
    <path d="M21.5 11 18 9l-6 4 3.5 2.5 6-4.5Z"></path>
    <path d="M2.5 11 6 9l6 4-3.5 2.5-6-4.5Z"></path>
    <path d="M18 14v4.5L12 22l-6-3.5V14"></path>
</svg>