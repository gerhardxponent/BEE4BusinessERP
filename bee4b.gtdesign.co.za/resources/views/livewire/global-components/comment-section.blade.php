<div x-data="{ reply: false, attachFiles: false, }">
    <div class="flex justify-between items-center mb-2">
        <div class="font-bold text-lg">
            {{ count($entity->comments) }} 
            Comments
        </div>
        <div>
            <x-button x-on:click="attachFiles = !attachFiles">
                <div>
                    <div x-show="!attachFiles" class="flex gap-1 items-center">
                        <x-icons.paperclip size="18" />
                        <div>Attach Files</div>
                    </div>
                    <div x-show="attachFiles" class="flex gap-1 items-center">
                        <x-icons.close size="18" />
                        <div>Cancel</div>
                    </div>
                </div>
            </x-button>
        </div>
    </div>

    <div x-show="attachFiles" x-collapse>
        <x-input.filepond wire:model="files" key="comment-files" multiple />
    </div>

    <div class="flex flex-col items-end space-y-2">
        <div class="w-full space-y-2">
            <x-mention wire:model.defer="newComment.body" :mentionables="$users" />
        </div>
        <x-button x-on:click="Livewire.emit('createComment', window.location.href)">
            Post comment
        </x-button>
    </div>

    <div class="space-y-6 mt-6 divide-y">
        {{-- ADD IN EAGER LOADING HERE --}}

        @foreach($this->comments as $comment)
            <div class="comment-container w-full p-4 rounded-lg @if($comment->pinned) outline outline-1 outline-indigo-500 @endif">
                <div class="flex flex-col">
                    <div class="group">
                        <div class="flex flex-row items-center gap-2 comment-author mb-2">
                            <div class="flex flex-row items-center gap-2">
                                <div>
                                    <x-initials :userNames="[$comment->user->name?? '']" max="1" />
                                </div>
                                <span class="font-bold">{{ $comment->user->name?? '' }}</span>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($comment->user_id == Auth::id())
                            <div 
                                class="cursor-pointer text-red-600 comment-delete-button flex flex-row opacity-0 group-hover:opacity-100 transition-opacity" 
                                wire:click="confirmDeleteComment({{ $comment->id }})"
                                >
                                <x-icons.bin width="16" height="16" />
                                <span class="text-xs">Delete</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <livewire:global-components.comment-body 
                            wire:key="comment-body-component-{{ $comment->id }}" 
                            :comment="$comment" 
                            :users="$users" 
                        />
                    </div>

                    {{-- <div>{!! $comment->body !!}</div> --}}

                    {{-- <div>
                        <x-button x-on:click="reply = !reply;">Reply</x-button>
                    </div>

                    <div x-show="reply">
                        Replying
                    </div> --}}
                </div>
            </div>
        @endforeach
    </div>

    {{-- MODALS --}}
    <x-jet-confirmation-modal wire:model="showConfirmDeleteCommentModal">
        <x-slot name="title">Delete comment</x-slot>

        <x-slot name="content">
            <div>
                <div>Are you sure you would like to delete this comment?</div>
                @if(count($deletingComment->replies) > 0)
                <div class="text-red-500 text-sm">This will delete all replies as well</div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end items-center gap-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteComment">Delete</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>
    {{-- END MODALS --}}

    <script>
        // const fileInput = document.querySelector('.file-input');

        // window.addEventListener('paste', e => {
        //     fileInput.files = e.clipboardData.files;
        //     console.log(fileInput.files);
        // });
    </script>
</div>