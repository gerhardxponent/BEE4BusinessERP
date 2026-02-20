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

        <div class="flex flex-col items-end space-y-2">
            <?php if(session()->has('message')): ?>
                <div class="px-3 py-1 rounded-md bg-green-100 text-green-800 text-sm"><?php echo e(session('message')); ?></div>
            <?php endif; ?>
            <div class="flex items-center gap-2">
                <?php if(method_exists($audit, 'trashed') && $audit->trashed()): ?>
                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">Archived</span>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'restore']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'restore']); ?>Restore <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.danger-button','data' => ['wire:click' => 'archive']]); ?>
<?php $component->withName('jet-danger-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'archive']); ?>Archive <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="rounded-2xl h-3/4 bg-gray-700" style="position: relative;background-color: rgb(245, 247, 249);">

<?php if($audit->board_id && $this->projectProgress): ?>
<div class="p-4" style="position: relative; height: 100%; background-color: rgb(245, 247, 249);">
    <div class="flex justify-between items-center mb-3">
        <h3 class="text-base font-bold text-gray-800">Project: <?php echo e($this->projectProgress['project']); ?></h3>
        <a href="/projects/<?php echo e($this->projectProgress['board_id']); ?>" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
            View →
        </a>
    </div>
    
    <div class="space-y-2">
        <?php $__currentLoopData = $this->projectProgress['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center gap-3">
                
                <div class="text-xs font-medium text-gray-700 text-right flex-shrink-0" style="width: 120px;">
                    <?php echo e($category['category']); ?>

                </div>
                
                
                <div class="flex-1 h-6 bg-gray-200 rounded-full overflow-hidden flex">
                    <?php if($category['percent']['complete'] > 0): ?>
                        <div 
                            class="bg-green-500 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: <?php echo e($category['percent']['complete']); ?>%;"
                            title="Complete: <?php echo e($category['counts']['complete']); ?> (<?php echo e($category['percent']['complete']); ?>%)"
                        >
                            <?php if($category['percent']['complete'] >= 8): ?>
                                <?php echo e($category['counts']['complete']); ?>

                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($category['percent']['active'] > 0): ?>
                        <div 
                            class="bg-blue-500 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: <?php echo e($category['percent']['active']); ?>%;"
                            title="Active: <?php echo e($category['counts']['active']); ?> (<?php echo e($category['percent']['active']); ?>%)"
                        >
                            <?php if($category['percent']['active'] >= 8): ?>
                                <?php echo e($category['counts']['active']); ?>

                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($category['percent']['inactive'] > 0): ?>
                        <div 
                            class="bg-gray-400 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: <?php echo e($category['percent']['inactive']); ?>%;"
                            title="Inactive: <?php echo e($category['counts']['inactive']); ?> (<?php echo e($category['percent']['inactive']); ?>%)"
                        >
                            <?php if($category['percent']['inactive'] >= 8): ?>
                                <?php echo e($category['counts']['inactive']); ?>

                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($category['percent']['red_flag'] > 0): ?>
                        <div 
                            class="bg-red-500 flex items-center justify-center text-white text-xs font-semibold"
                            style="width: <?php echo e($category['percent']['red_flag']); ?>%;"
                            title="Red Flag: <?php echo e($category['counts']['red_flag']); ?> (<?php echo e($category['percent']['red_flag']); ?>%)"
                        >
                            <?php if($category['percent']['red_flag'] >= 8): ?>
                                <?php echo e($category['counts']['red_flag']); ?>

                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                
                <div class="text-xs font-semibold text-gray-700 text-right flex-shrink-0" style="width: 40px;">
                    <?php echo e($category['total']); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    
    <div class="mt-3 pt-2 flex justify-center gap-3 text-xs">
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-green-500 rounded"></span>
            <span class="text-gray-600">Done</span>
        </div>
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-blue-500 rounded"></span>
            <span class="text-gray-600">Active</span>
        </div>
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-gray-400 rounded"></span>
            <span class="text-gray-600">Inactive</span>
        </div>
        <div class="flex items-center gap-1">
            <span class="w-2 h-2 bg-red-500 rounded"></span>
            <span class="text-gray-600">Flag</span>
        </div>
    </div>
</div>
<?php else: ?>

<div class="h-3/4 flex items-center justify-center" style="position: relative;background-color: rgb(245, 247, 249);">
    <div class="text-center text-gray-500">
        <div class="text-lg font-semibold mb-1">No Project Linked</div>
        <div class="text-sm">This audit does not have a project associated with it.</div>
    </div>
</div>
<?php endif; ?>
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
} elseif ($_instance->childHasBeenRendered('l3383048626-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3383048626-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3383048626-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3383048626-1');
} else {
    $response = \Livewire\Livewire::mount('audit-management.components.audit-section', ['id' => ''.e($audit->id).'','searchTerm' => $searchTerm]);
    $html = $response->html();
    $_instance->logRenderedChild('l3383048626-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        <?php endif; ?>

        <?php if($currentTab == 'edit-details'): ?>
            <div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.edit-audit-details', ['auditId' => $audit->id])->html();
} elseif ($_instance->childHasBeenRendered('edit-audit-' . $audit->id)) {
    $componentId = $_instance->getRenderedChildComponentId('edit-audit-' . $audit->id);
    $componentTag = $_instance->getRenderedChildComponentTagName('edit-audit-' . $audit->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('edit-audit-' . $audit->id);
} else {
    $response = \Livewire\Livewire::mount('audit-management.edit-audit-details', ['auditId' => $audit->id]);
    $html = $response->html();
    $_instance->logRenderedChild('edit-audit-' . $audit->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
} elseif ($_instance->childHasBeenRendered('l3383048626-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l3383048626-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3383048626-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3383048626-3');
} else {
    $response = \Livewire\Livewire::mount('audit-management.components.audit-export-table', ['audit' => $audit]);
    $html = $response->html();
    $_instance->logRenderedChild('l3383048626-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/audit-management/audit-details.blade.php ENDPATH**/ ?>