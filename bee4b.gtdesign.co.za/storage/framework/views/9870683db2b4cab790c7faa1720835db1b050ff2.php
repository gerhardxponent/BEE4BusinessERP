<div class="relative space-y-4">
    

    
    <div>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.details-header','data' => []]); ?>
<?php $component->withName('details-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
             <?php $__env->slot('initials', null, []); ?> 
                <div class="w-20 h-20">
                    <?php echo $managementProcess->icon->svg; ?>

                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('headerDetails', null, []); ?> 
                <div class="text-2xl my-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inline-edit','data' => ['original' => $managementProcess->name,'model' => 'ManagementProcess','entityId' => $managementProcess->id,'field' => 'name','name' => 'managementProcess-name']]); ?>
<?php $component->withName('inline-edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['original' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($managementProcess->name),'model' => 'ManagementProcess','entityId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($managementProcess->id),'field' => 'name','name' => 'managementProcess-name']); ?>
<?php echo $__env->renderComponent(); ?>
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
    </div>
    
    

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab-layout','data' => []]); ?>
<?php $component->withName('tabs.tab-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab','data' => ['click' => 'changeTab(\''.e($tab).'\')','current' => $currentTab === $tab ? true : false]]); ?>
<?php $component->withName('tabs.tab'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['click' => 'changeTab(\''.e($tab).'\')','current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab === $tab ? true : false)]); ?>
                <?php echo e(ucfirst($tab)); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if($currentTab === 'projects'): ?>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.projects', ['entity' => $managementProcess,'activityPath' => 'Management'])->html();
} elseif ($_instance->childHasBeenRendered('l1323173121-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1323173121-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1323173121-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1323173121-0');
} else {
    $response = \Livewire\Livewire::mount('global-components.projects', ['entity' => $managementProcess,'activityPath' => 'Management']);
    $html = $response->html();
    $_instance->logRenderedChild('l1323173121-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php endif; ?>

    <?php if($currentTab === 'files'): ?>
        <div>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.files-section', ['entity' => $managementProcess,'model' => 'App\\Models\\ManagementProcess','filePath' => 'Management/' . $managementProcess->name])->html();
} elseif ($_instance->childHasBeenRendered('l1323173121-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1323173121-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1323173121-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1323173121-1');
} else {
    $response = \Livewire\Livewire::mount('global-components.files-section', ['entity' => $managementProcess,'model' => 'App\\Models\\ManagementProcess','filePath' => 'Management/' . $managementProcess->name]);
    $html = $response->html();
    $_instance->logRenderedChild('l1323173121-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    <?php endif; ?>

    <?php if($currentTab === 'contacts'): ?>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('contacts.contacts-table', ['entity' => $managementProcess])->html();
} elseif ($_instance->childHasBeenRendered('l1323173121-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l1323173121-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1323173121-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1323173121-2');
} else {
    $response = \Livewire\Livewire::mount('contacts.contacts-table', ['entity' => $managementProcess]);
    $html = $response->html();
    $_instance->logRenderedChild('l1323173121-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php endif; ?>

    <?php if($currentTab === 'activity'): ?>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.activity', ['model' => 'App\\Models\\ManagementProcess','entityID' => ''.e($managementProcess->id).'','showPath' => true])->html();
} elseif ($_instance->childHasBeenRendered('l1323173121-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l1323173121-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1323173121-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1323173121-3');
} else {
    $response = \Livewire\Livewire::mount('global-components.activity', ['model' => 'App\\Models\\ManagementProcess','entityID' => ''.e($managementProcess->id).'','showPath' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('l1323173121-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php endif; ?>

    
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/management/management-details.blade.php ENDPATH**/ ?>