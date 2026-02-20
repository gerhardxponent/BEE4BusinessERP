<div>
    <div class="flex w-full">
        <div class="w-1/6 pr-6 border-r border-gray-200">
            <div class="text-lg font-bold mb-4 flex justify-between items-center">
                <div>Roles</div>
                <div wire:click="toggleNewRole" class="cursor-pointer hover:bg-indigo-100 active:bg-indigo-200 p-1 rounded-md">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.plus','data' => []]); ?>
<?php $component->withName('icons.plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <?php $__currentLoopData = $this->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div 
                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'p-2 rounded-md cursor-pointer',
                            'bg-indigo-100 text-indigo-900 font-bold' => $currentRole == $role->id,
                            'hover:bg-gray-200 active:bg-gray-300' => $currentRole != $role->id,
                        ]) ?>"
                        wire:click="changeRole('<?php echo e($role->id); ?>')"
                        >
                        <div>
                            <?php echo e(ucfirst($role->name)); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="pl-6">
            <?php if($newRole): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['title' => 'Create New Role'])->html();
} elseif ($_instance->childHasBeenRendered('l3476982914-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3476982914-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3476982914-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3476982914-0');
} else {
    $response = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['title' => 'Create New Role']);
    $html = $response->html();
    $_instance->logRenderedChild('l3476982914-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php else: ?>
            
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['role' => $this->getRole(),'title' => 'Permissions'])->html();
} elseif ($_instance->childHasBeenRendered('l3476982914-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3476982914-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3476982914-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3476982914-1');
} else {
    $response = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['role' => $this->getRole(),'title' => 'Permissions']);
    $html = $response->html();
    $_instance->logRenderedChild('l3476982914-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/settings/components/roles-and-permissions.blade.php ENDPATH**/ ?>