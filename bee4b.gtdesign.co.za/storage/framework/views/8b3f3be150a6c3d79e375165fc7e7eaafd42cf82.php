<div wire:loading.class="opacity-50 transition-opacity" wire:target="changeTab">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input.filepond','data' => ['wire:model' => 'files','multiple' => true,'key' => 'fp_files']]); ?>
<?php $component->withName('input.filepond'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'files','multiple' => true,'key' => 'fp_files']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="w-full flex flex-row justify-center">
        <button
            wire:click="upload"
            <?php if(!$enableUpload || count($files) == 0): ?> disabled <?php endif; ?>
            class="flex flex-row space-x-1 items-center px-4 py-2 bg-primary-normal hover:bg-primary-light active:bg-primary-dark border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
            >
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.file-upload','data' => []]); ?>
<?php $component->withName('icons.file-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <span>Upload Files</span>
        </button>
    </div>

    
    <div class="mt-2">
        
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.global-files-table', ['entity' => $entity])->html();
} elseif ($_instance->childHasBeenRendered('l3401834458-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3401834458-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3401834458-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3401834458-0');
} else {
    $response = \Livewire\Livewire::mount('global-components.global-files-table', ['entity' => $entity]);
    $html = $response->html();
    $_instance->logRenderedChild('l3401834458-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.file-details-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('l3401834458-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3401834458-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3401834458-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3401834458-1');
} else {
    $response = \Livewire\Livewire::mount('global-components.file-details-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3401834458-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    
    

    
    
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/global-components/files-section.blade.php ENDPATH**/ ?>