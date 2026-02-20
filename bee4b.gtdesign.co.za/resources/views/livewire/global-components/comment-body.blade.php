<div x-data="{ reply: false }">
    <div>
        {!! $comment->body !!}
    </div>

    <div class="flex gap-1">
        <button 
            x-on:click="reply = !reply"
            class="text-sm flex flex-row justify-start items-center gap-1 hover:bg-purple-100 active:bg-purple-200 px-2 py-1 rounded-lg my-1"
            :class="{ 'bg-purple-100' : reply }"
        >
            <x-icons.reply />
            <div>Reply</div>
        </button>

        <button 
            wire:click="pinComment"
            class="text-sm flex flex-row justify-start items-center gap-1 hover:bg-blue-100 active:bg-blue-200 @if($comment->pinned === 1) bg-blue-100 @endif px-2 py-1 rounded-lg my-1"
        >
            @if ($comment->pinned === 0)
                <x-icons.pinned size="20" />
                <div>Pin</div>       
            @else
                <x-icons.unpin size="20" />
                <div>Unpin</div> 
            @endif
        </button>
    </div>

    <div class="flex gap-2 flex-wrap">
        @foreach ($comment->files as $file)
            <div class="bg-gray-100 rounded p-2 text-gray-800">
                <a href="../file-viewer/{{ $file->id }}" target="_blank" class="font-bold text-blue-600 hover:underline cursor-pointer">
                    {{ $file->file_name }}
                </a>
            </div>
        @endforeach
    </div>

    {{-- <x-button wire:click="pinComment">Pin</x-button>  --}}

    <div x-show="reply" x-trap="reply" x-collapse class="w-full space-y-1 flex flex-col items-end">
        <div class="w-full">
            <x-mention 
                wire:model.defer="commentReply.body" 
                :mentionables="$users" 
                :mentionID="'comment-reply-' . $comment->id"
            />
        </div>
        <div>
            <x-button 
                x-on:click="() => {
                    Livewire.emit('postReply-{{ $comment->id }}', window.location.href);
                    reply = false;
                }"
                >
                Post Reply
            </x-button>
        </div>
    </div>

    <div class="space-y-6 border-l border-gray-200 ml-8 mt-4 pl-8 bg-white">
        @foreach ($comment->replies as $reply)
            <div class="flex flex-row items-start">
                <div class="flex flex-col group">
                    <div class="flex flex-row items-center gap-2 comment-author mb-2">
                        <div class="flex flex-row items-center gap-2">
                            <div>
                                <x-initials :userNames="[$reply->user->name??'']" max="1" />
                            </div>
                            <span class="font-bold">{{ $reply->user->name??'' }}</span>
                            <span class="text-xs text-gray-500">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($reply->user_id == Auth::id())
                        <div 
                            class="cursor-pointer text-red-600 comment-delete-button flex flex-row opacity-0 group-hover:opacity-100 transition-opacity" 
                            wire:click="$emit('confirmDeleteComment', '{{ $reply->id }}')"
                            >
                            <x-icons.bin width="16" height="16" />
                            <span class="text-xs">Delete</span>
                        </div>
                        @endif
                    </div>

                    <div>
                        {!! $reply->body !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
