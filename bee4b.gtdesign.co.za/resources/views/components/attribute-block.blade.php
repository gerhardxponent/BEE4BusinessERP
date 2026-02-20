<div class="grid grid-cols-2 border border-gray-200 p-8">
    <div class="space-y-2 grid-rows-{{ $attributeCount }} ">
        {{ $attributeNames }}
    </div>
    <div class="space-y-2 grid-rows-{{ $attributeCount }}">
        {{ $attributeValues }}
    </div>
</div>

{{-- @props([
    'headerDetails',
    'editMode'
])

<table class="w-1/4">
    @foreach($headerDetails as $key => $value)
    <tr>    
        <td class="font-bold">{{ $key }}</td>
        @if($editMode)
        <td><x-jet-input type="text"/></td>
        @else
        <td>{{ $value }}</td>
        @endif
    </tr>
    @endforeach
</table> --}}