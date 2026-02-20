@props([
    'width' => '24',
    'height' => '24',
    'size' => null
])

<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-trello" width="{{ isset($size) ? $size : $width }}" height="{{ isset($size) ? $size : $height }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <rect x="4" y="4" width="16" height="16" rx="2"></rect>
    <path d="M7 7h3v10h-3z"></path>
    <path d="M14 7h3v6h-3z"></path>
</svg>