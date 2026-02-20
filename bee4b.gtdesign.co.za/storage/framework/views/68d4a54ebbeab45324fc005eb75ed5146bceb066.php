<div class="relative">
   

   

   

   

   

   <div class="fixed z-50 top-20 right-5 space-y-4">
      <?php if(session()->has('created_client')): ?>
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success','data' => ['message' => ''.e(session('created_client')).'']]); ?>
<?php $component->withName('toast.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['message' => ''.e(session('created_client')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      <?php endif; ?>
   </div>

   

   <div class="mt-4 space-y-2 ">
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clients.clients-table', [])->html();
} elseif ($_instance->childHasBeenRendered('l2391612559-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2391612559-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2391612559-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2391612559-0');
} else {
    $response = \Livewire\Livewire::mount('clients.clients-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('l2391612559-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>

   <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'restoreModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'restoreModal']); ?>
       <?php $__env->slot('title', null, []); ?> Restore Client <?php $__env->endSlot(); ?>
       <?php $__env->slot('content', null, []); ?> 
         <div>
            Would you like to restore this client or permanently delete it?
         </div>
       <?php $__env->endSlot(); ?>
       <?php $__env->slot('footer', null, []); ?> 
         <div class="flex justify-end items-center gap-1">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['wire:click' => 'restore']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'restore']); ?>Restore <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['class' => 'bg-red-500','wire:click' => 'permanentlyDelete']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'bg-red-500','wire:click' => 'permanentlyDelete']); ?>Delete <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
         </div>
       <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/clients/client-index.blade.php ENDPATH**/ ?>