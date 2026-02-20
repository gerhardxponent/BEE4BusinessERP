@props([
    'width' => '24',
    'height' => '24',
    'size' => null
])

<svg width="{{ isset($size) ? $size : $width }}" height="{{ isset($size) ? $size : $height }}" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M7 13H6a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2Z"></path>
  <path d="M18 13h-1a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2Z"></path>
  <path d="M4 15v-3a8 8 0 1 1 16 0v3"></path>
</svg>