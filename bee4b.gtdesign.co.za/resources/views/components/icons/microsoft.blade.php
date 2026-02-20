@props([
    'width' => '24',
    'height' => '24',
    'size' => null
])

<svg width="{{ isset($size) ? $size : $width }}" height="{{ isset($size) ? $size : $height }}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M11.328 2H2v8.988h9.328V2ZM22 2h-9.328v8.988H22V2ZM11.328 12.264H2V22h9.328v-9.736Zm10.672 0h-9.328V22H22v-9.736Z"></path>
</svg>