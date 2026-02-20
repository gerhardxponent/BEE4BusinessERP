<div>
    <div class="ml-6">
        @foreach($client->activities as $activity)
            <div class="relative flex items-center activity-section border-l-2 border-indigo-300 py-4 pr-4 w-full">
                {{-- Icon --}}
                <div class="-translate-x-1/2">
                    <div class="bg-indigo-500 rounded-full p-1 text-white">
                        @switch($activity->activity_type)
                            @case('file upload')
                                <x-icons.file-upload />
                                @break

                            @case('create')
                                <x-icons.plus />
                                @break

                            @case('update')
                                <x-icons.refresh />
                                @break

                            @case('delete')
                                <x-icons.bin />
                                @break
                            
                            @case('task status change')
                                <x-icons.check />
                                @break

                            @case('comment')
                                <x-icons.comment />
                                @break
                        
                            @default
                                <x-icons.plus />
                        @endswitch
                    </div>
                </div>
                {{-- End icon --}}

                {{-- Card --}}
                <div class="flex flex-col bg-white rounded-lg p-4 shadow-md border-l-2 border-indigo-400">
                    <div class="flex flex-row items-center justify-start mb-2 space-x-1">
                        <div class="mr-1 shadow-md border-2 border-white w-8 h-8 bg-indigo-200 text-base p-2 rounded-full flex items-center justify-center">
                            <span class="font-bold text-sm">{{ $this->generateInitials($activity->user->name) }}</span>
                        </div>
                        <div>
                            <span>
                                <span class="font-bold">{{ $activity->user->name }}</span> {!! $activity->title !!}
                            </span>
                            <span class="text-gray-700 text-sm"> - {{ $this->activityTime($activity->created_at) }}</span>
                        </div>
                    </div>
                    <div>{!! $activity->body !!}</div>
                </div>
                {{-- End card --}}
            </div>
        @endforeach
    </div>
</div>
