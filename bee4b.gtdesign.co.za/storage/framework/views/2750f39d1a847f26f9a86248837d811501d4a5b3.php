<div>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success-event','data' => []]); ?>
<?php $component->withName('toast.success-event'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('contacts.contacts-table', [])->html();
} elseif ($_instance->childHasBeenRendered('l1857042095-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1857042095-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1857042095-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1857042095-0');
} else {
    $response = \Livewire\Livewire::mount('contacts.contacts-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1857042095-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            
                
            
        </div>
    </div>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('contacts.create-contact', [])->html();
} elseif ($_instance->childHasBeenRendered('l1857042095-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1857042095-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1857042095-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1857042095-1');
} else {
    $response = \Livewire\Livewire::mount('contacts.create-contact', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1857042095-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/contacts/contact-index.blade.php ENDPATH**/ ?>