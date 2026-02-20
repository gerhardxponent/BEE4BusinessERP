<div x-data="{ reply: false }">
    <div>
        <?php echo $comment->body; ?>

    </div>

    <div class="flex gap-1">
        <button 
            x-on:click="reply = !reply"
            class="text-sm flex flex-row justify-start items-center gap-1 hover:bg-purple-100 active:bg-purple-200 px-2 py-1 rounded-lg my-1"
            :class="{ 'bg-purple-100' : reply }"
        >
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.reply','data' => []]); ?>
<?php $component->withName('icons.reply'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <div>Reply</div>
        </button>

        <button 
            wire:click="pinComment"
            class="text-sm flex flex-row justify-start items-center gap-1 hover:bg-blue-100 active:bg-blue-200 <?php if($comment->pinned === 1): ?> bg-blue-100 <?php endif; ?> px-2 py-1 rounded-lg my-1"
        >
            <?php if($comment->pinned === 0): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.pinned','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.pinned'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div>Pin</div>       
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.unpin','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.unpin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div>Unpin</div> 
            <?php endif; ?>
        </button>
    </div>

    <div class="flex gap-2 flex-wrap">
        <?php $__currentLoopData = $comment->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-100 rounded p-2 text-gray-800">
                <a href="../file-viewer/<?php echo e($file->id); ?>" target="_blank" class="font-bold text-blue-600 hover:underline cursor-pointer">
                    <?php echo e($file->file_name); ?>

                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    

    <div x-show="reply" x-trap="reply" x-collapse class="w-full space-y-1 flex flex-col items-end">
        <div class="w-full">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.mention','data' => ['wire:model.defer' => 'commentReply.body','mentionables' => $users,'mentionID' => 'comment-reply-' . $comment->id]]); ?>
<?php $component->withName('mention'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model.defer' => 'commentReply.body','mentionables' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($users),'mentionID' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('comment-reply-' . $comment->id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['xOn:click' => '() => {
                    Livewire.emit(\'postReply-'.e($comment->id).'\', window.location.href);
                    reply = false;
                }']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click' => '() => {
                    Livewire.emit(\'postReply-'.e($comment->id).'\', window.location.href);
                    reply = false;
                }']); ?>
                Post Reply
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
    </div>

    <div class="space-y-6 border-l border-gray-200 ml-8 mt-4 pl-8 bg-white">
        <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex flex-row items-start">
                <div class="flex flex-col group">
                    <div class="flex flex-row items-center gap-2 comment-author mb-2">
                        <div class="flex flex-row items-center gap-2">
                            <div>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.initials','data' => ['userNames' => [$reply->user->name??''],'max' => '1']]); ?>
<?php $component->withName('initials'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['userNames' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$reply->user->name??'']),'max' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                            <span class="font-bold"><?php echo e($reply->user->name??''); ?></span>
                            <span class="text-xs text-gray-500"><?php echo e($reply->created_at->format('d/m/Y H:i')); ?></span>
                        </div>
                        <?php if($reply->user_id == Auth::id()): ?>
                        <div 
                            class="cursor-pointer text-red-600 comment-delete-button flex flex-row opacity-0 group-hover:opacity-100 transition-opacity" 
                            wire:click="$emit('confirmDeleteComment', '<?php echo e($reply->id); ?>')"
                            >
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.bin','data' => ['width' => '16','height' => '16']]); ?>
<?php $component->withName('icons.bin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['width' => '16','height' => '16']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <span class="text-xs">Delete</span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div>
                        <?php echo $reply->body; ?>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/global-components/comment-body.blade.php ENDPATH**/ ?>