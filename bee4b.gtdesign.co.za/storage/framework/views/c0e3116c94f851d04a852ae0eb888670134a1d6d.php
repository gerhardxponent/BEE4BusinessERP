<div>
    

    <div class="fixed z-50 top-20 right-5 space-y-4">
        <?php if(session()->has('message')): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success','data' => ['message' => ''.e(session('message')).'']]); ?>
<?php $component->withName('toast.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['message' => ''.e(session('message')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
    </div>

    

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('consultations.consultations-table', [])->html();
} elseif ($_instance->childHasBeenRendered('l1322069329-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1322069329-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1322069329-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1322069329-0');
} else {
    $response = \Livewire\Livewire::mount('consultations.consultations-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1322069329-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('consultations.components.create-consultation-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('l1322069329-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1322069329-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1322069329-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1322069329-1');
} else {
    $response = \Livewire\Livewire::mount('consultations.components.create-consultation-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1322069329-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/consultations/consultation-index.blade.php ENDPATH**/ ?>