@props([
    'userNames' => [],
    'max' => 20,
])

@php
    $userInitials = [];
    $count = 1;

    foreach ($userNames as $key => $name) {
        if($name != '') {
            $nameExplode = explode(" ", $name);
            $initials = '';
            $initials .= $nameExplode[0][0];
            $initials .= end($nameExplode)[0];

            array_push($userInitials, $initials);
        }
    }
@endphp

<div class="flex gap-1">
    @foreach ($userInitials as $initials)
        @if ($count <= $max)
        <div class="avatar shadow-md border-2 border-white w-8 h-8 bg-violet-200 text-base rounded-full flex items-center justify-center">
            <div class="font-bold text-black text-sm">{{ $initials }}</div>
        </div>
        @php ++$count; @endphp
        @endif
    @endforeach

    {{-- @for ($i = 0; $i < $max; $i++)
        <div class="avatar shadow-md border-2 border-white w-8 h-8 bg-violet-200 text-base rounded-full flex items-center justify-center">
            <div class="font-bold text-black text-sm">{{ $userInitials[$i] }}</div>
        </div>
    @endfor --}}

    @if (count($userNames) > $max && $max != 0) 
        <div class="avatar shadow-md border-2 border-white w-8 h-8 bg-violet-200 text-base rounded-full flex items-center justify-center">
            <div class="font-bold text-black text-sm">+{{ count($userNames) - $max }}</div>
        </div>
    @endif
</div>