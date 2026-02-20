@props([
    'field' => '',
    'customMessage' => null
])

<span>
    @error($field) 
        <span class="text-red-500 text-sm">{{ isset($customMessage) ? $customMessage : $message }}</span> 
    @else
        <div class="text-sm text-gray-500">Required</div>
    @enderror
</span>