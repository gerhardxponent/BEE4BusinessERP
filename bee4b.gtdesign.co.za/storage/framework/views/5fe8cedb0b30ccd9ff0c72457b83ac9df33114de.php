<div
    x-init="function() {
        $(document).ready(function() {
            Livewire.on('chat-clicked', function() {
                const el = document.querySelector('.message-box');
                if(el != null) {
                    el.scrollTop += 100;
                    console.log(el.scrollTop);
                }
            });
        });
    }"
    >
    <style>
        .message-box {
            height: 86vh !important;
            background-color: white !important;
            overflow-y: scroll;
        }
    </style>

    <div class="bg-white p-6 w-full rounded-lg message-box test-box relative flex flex-col justify-between">
        <?php if($activeChat->id != null): ?>
            <div class="overflow-y-scroll pb-4" wire:key="message-container">
            <?php $__currentLoopData = $activeChat->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($index == 0 || $activeChat->messages[$index-1]->created_at->format('d M Y') != $message->created_at->format('d M Y')): ?>
                <div class="flex items-center justify-center text-gray-400 mt-4 sticky top-0 bg-white">
                    <div><?php echo e($message->created_at->format('d M Y')); ?></div>
                </div>
                <?php endif; ?>
                

                
                <?php if($message->user_id == $user->id): ?> 
                <div class="flex flex-col items-end" wire:key="my-message-<?php echo e($message->id); ?>">
                    
                    <div class="flex justify-end items-center gap-1 w-3/4">
                        <div class="bg-blue-500 text-white text-lg rounded-t-2xl rounded-bl-2xl px-4 py-2 mt-2">
                            <div class="break-all"><?php echo e($message->content); ?></div>
                        </div>
                        <?php if($activeChat->isGroup === 1): ?>
                        <div class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 bg-blue-200 text-base p-2 rounded-full flex items-center justify-center">
                            <span class="font-bold text-black">
                                <?php echo e($this->generateInitials($message->user->name)); ?>

                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    

                    
                    <div class="text-gray-500 text-sm flex gap-1">
                        <div><?php echo e($message->created_at->format('H:i')); ?></div>
                    </div>
                    
                </div>
                <?php else: ?> 
                <div class="flex flex-col items-start" wire:key="recieved-message-<?php echo e($message->id); ?>">
                    
                    <div class="flex justify-start items-center gap-1 w-3/4">
                        <?php if($activeChat->isGroup === 1): ?>
                        <div class="avatar cursor-pointer mr-1 shadow-md border-2 border-white w-10 h-10 bg-blue-200 text-base p-2 rounded-full flex items-center justify-center">
                            <span class="font-bold text-black">
                                <?php echo e($this->generateInitials($message->user->name)); ?>

                            </span>
                        </div>
                        <?php endif; ?>
                        <div class="bg-gray-200 text-black text-lg rounded-t-2xl rounded-br-2xl px-4 py-2 mt-2">
                            <div class="break-all"><?php echo e($message->content); ?></div>
                        </div>
                    </div>
                    

                    
                    <div class="text-gray-500 text-sm flex gap-1">
                        <div><?php echo e($message->created_at->format('H:i')); ?></div>
                    </div>
                    
                </div>
                <?php endif; ?>
                
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="sticky bottom-0 left-0 top-full w-full flex flex-row gap-4" style="box-shadow: 0px 1px 7px 9px #FFFFFF;" wire:key="message-box">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['placeholder' => 'Write a message...','type' => 'text','class' => '','wire:model.defer' => 'newMessage.content']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Write a message...','type' => 'text','class' => '','wire:model.defer' => 'newMessage.content']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'sendMessage']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'sendMessage']); ?>Send <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        <?php else: ?>
            <div class="flex flex-col justify-center items-center gap-4 h-full">
                <div class="text-xl text-gray-500">No chat selected</div>
                <div class="text-gray-500">Click on a contact on the left, or click the plus icon to start a new chat</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/support/components/chat-window.blade.php ENDPATH**/ ?>