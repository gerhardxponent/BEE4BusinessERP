<div class="relative">
    <div class="header grid grid-cols-2 my-4 items-center">
        <div>
            <div class="profile-header flex flex-row items-center space-x-4">
                <div class="profile-image rounded-md">
                    <div style="width:100px; height:100px;" class="bg-indigo-500 text-white rounded-md flex justify-center items-center">
                        <span class="text-4xl uppercase">
                            <div><?php echo e($this->generateInitials($client->name)); ?></div>
                        </span>
                    </div>
                </div>
                <div class="profile-header-details flex flex-col align-middle justify-center">
                    <div class="text-2xl">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.inline-edit', ['model' => '\\App\\Models\\Audit','entity' => $audit,'field' => 'name','permission' => 'edit audits','regex' => '^[^_^\/^\\\\]*$'])->html();
} elseif ($_instance->childHasBeenRendered('audit-'.$audit->id)) {
    $componentId = $_instance->getRenderedChildComponentId('audit-'.$audit->id);
    $componentTag = $_instance->getRenderedChildComponentTagName('audit-'.$audit->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('audit-'.$audit->id);
} else {
    $response = \Livewire\Livewire::mount('global-components.inline-edit', ['model' => '\\App\\Models\\Audit','entity' => $audit,'field' => 'name','permission' => 'edit audits','regex' => '^[^_^\/^\\\\]*$']);
    $html = $response->html();
    $_instance->logRenderedChild('audit-'.$audit->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                    <div class="text-gray-500">
                        <div><?php echo e($audit->created_at->format('Y-m-d')); ?></div>
                        <a <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view clients')): ?> href="../clients/<?php echo e($client->id); ?>" <?php endif; ?> class="underline hover:text-blue-600 cursor-pointer"><?php echo e($client->name); ?></a> 
                    </div>
                </div>
            </div>
        </div>
            
        <div class="rounded-2xl h-3/4 bg-gray-700" style="position: relative;">
            <div class="text-white h-full flex flex-col justify-center ml-4" style="position: absolute; z-index: 9999;">
                <div class="text-xl">Files accepted</div>
                <div class="text-sm text-gray-100"><span class="font-bold"><?php echo e(round($this->percentage)); ?>%</span> of files have been accepted</div>
            </div>
            <div class="relative z-10 h-full <?php if($this->percentage !== 100): ?> rounded-tl-2xl rounded-bl-2xl <?php else: ?> rounded-2xl <?php endif; ?>" 
                style="width:<?php echo e($this->percentage); ?>%; background-image: linear-gradient(90deg, #7474bf 0%, #348ac7 100%)">
            </div>
        </div>
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

    <div class="w-full grid grid-cols-1 mt-4" wire:key="zmncxmn">
        <?php if($currentTab == 'details'): ?>
            <div class="w-full">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.components.audit-section', ['id' => ''.e($audit->id).'','searchTerm' => $searchTerm])->html();
} elseif ($_instance->childHasBeenRendered('l3142349997-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3142349997-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3142349997-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3142349997-1');
} else {
    $response = \Livewire\Livewire::mount('audit-management.components.audit-section', ['id' => ''.e($audit->id).'','searchTerm' => $searchTerm]);
    $html = $response->html();
    $_instance->logRenderedChild('l3142349997-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        <?php endif; ?>

        <?php if($currentTab == 'exports'): ?>
            <div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.components.audit-export-table', ['audit' => $audit])->html();
} elseif ($_instance->childHasBeenRendered('l3142349997-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l3142349997-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3142349997-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3142349997-2');
} else {
    $response = \Livewire\Livewire::mount('audit-management.components.audit-export-table', ['audit' => $audit]);
    $html = $response->html();
    $_instance->logRenderedChild('l3142349997-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        <?php endif; ?>

        <div wire:key="audit-activities-container">
            <?php if($currentTab == 'activity'): ?>
                <div wire:key="audit-details-activity-component">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.activity', ['activities' => $activities,'showPath' => true,'model' => 'App\\Models\\Audit','entityID' => ''.e($audit->id).''])->html();
} elseif ($_instance->childHasBeenRendered('audit-activities')) {
    $componentId = $_instance->getRenderedChildComponentId('audit-activities');
    $componentTag = $_instance->getRenderedChildComponentTagName('audit-activities');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('audit-activities');
} else {
    $response = \Livewire\Livewire::mount('global-components.activity', ['activities' => $activities,'showPath' => true,'model' => 'App\\Models\\Audit','entityID' => ''.e($audit->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('audit-activities', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/audit-management/audit-details.blade.php ENDPATH**/ ?>