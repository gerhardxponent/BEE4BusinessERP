@props([
    'width' => '24',
    'height' => '24',
    'size' => null
])

<svg width="{{ isset($size) ? $size : $width }}" height="{{ isset($size) ? $size : $height }}" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M3 21h18"></path>
  <path d="M9 8h1"></path>
  <path d="M9 12h1"></path>
  <path d="M9 16h1"></path>
  <path d="M14 8h1"></path>
  <path d="M14 12h1"></path>
  <path d="M14 16h1"></path>
  <path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path>
</svg>