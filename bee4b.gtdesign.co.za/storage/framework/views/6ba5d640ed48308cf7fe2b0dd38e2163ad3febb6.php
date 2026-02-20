<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
   <?php $__env->slot('header', null, []); ?> 
    <h2 class="font-semibold text-xl text-gray-800">Audit Templates</h2>
   <?php $__env->endSlot(); ?>

  <div class="">
    <div class="">
      <!-- exactly the same “card” wrapper as your Create Audit page -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-template-builder')->html();
} elseif ($_instance->childHasBeenRendered('0KmlJaT')) {
    $componentId = $_instance->getRenderedChildComponentId('0KmlJaT');
    $componentTag = $_instance->getRenderedChildComponentTagName('0KmlJaT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0KmlJaT');
} else {
    $response = \Livewire\Livewire::mount('audit-template-builder');
    $html = $response->html();
    $_instance->logRenderedChild('0KmlJaT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
      </div>
    </div>
  </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/settings/audit-templates.blade.php ENDPATH**/ ?>