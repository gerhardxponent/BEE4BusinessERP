<div>
    <div class="pr-6 border-r border-gray-200 flex flex-col gap-1">
        @foreach ($sections as $section)
            <div 
                @class([
                    'p-2 rounded-md cursor-pointer',
                    'bg-indigo-100 text-indigo-900 font-bold' => $currentSection == $section,
                    'hover:bg-gray-200 active:bg-gray-300' => $currentSection != $section,
                ])
                wire:click="changeSection('{{ $section }}')"
                >
                {{ ucfirst($section) }}
            </div>
        @endforeach
    </div>
</div>
