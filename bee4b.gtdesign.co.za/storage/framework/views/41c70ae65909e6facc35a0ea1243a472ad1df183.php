<?php if($archives): ?>
<div x-data="{ archived: false, }">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['xOn:click' => '() => { 
            archived = !archived;
            Livewire.emit(\'toggleShowDeleted\')
        }','xHtml' => '!archived ? \'Archived\' : \'Active\'']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click' => '() => { 
            archived = !archived;
            Livewire.emit(\'toggleShowDeleted\')
        }','x-html' => '!archived ? \'Archived\' : \'Active\'']); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div>
<?php endif; ?><?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/archive.blade.php ENDPATH**/ ?>