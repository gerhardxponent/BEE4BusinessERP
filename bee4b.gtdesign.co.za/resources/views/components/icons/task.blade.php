@props([
    'width' => '24',
    'height' => '24',
    'size' => null
])

<svg width="{{ isset($size) ? $size : $width }}" height="{{ isset($size) ? $size : $height }}" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M6 9h6"></path>
  <path d="M4 5h4"></path>
  <path d="M6 5v11a1 1 0 0 0 1 1h5"></path>
  <path d="M19 7h-6a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1Z"></path>
  <path d="M19 15h-6a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1Z"></path>
</svg>