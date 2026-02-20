<div>
    <div class="flex w-full">
        <div class="w-1/6 pr-6 border-r border-gray-200">
            <div class="text-lg font-bold mb-4 flex justify-between items-center">
                <div>Dropdown Items</div>
            </div>
            <div class="flex flex-col gap-1">
                <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div 
                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'p-2 rounded-md cursor-pointer',
                            'bg-indigo-100 text-indigo-900 font-bold' => $currentProperty == $property,
                            'hover:bg-gray-200 active:bg-gray-300' => $currentProperty != $property,
                        ]) ?>"
                        wire:click="changeProperty('<?php echo e($property); ?>')"
                        >
                        <div>
                            <?php echo e($property); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="pl-6 w-full">
            <div class="bg-white p-4 rounded-lg w-full">
                <div class="text-sm text-gray-500 flex gap-1 items-center mb-4">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.info','data' => []]); ?>
<?php $component->withName('icons.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <div>Click on an item name to edit it, click the New button to create new items or click Delete to delete an item</div>
                </div>
        
                <div class="px-8 pb-6">
                    <div x-data="{ newItem: false }" wire:key="<?php echo e($currentProperty); ?>-current">
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold"><?php echo e($currentProperty); ?></div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['xOn:click' => '() => {
                                    newItem = !newItem;
                                    newItem && setTimeout(() => $refs.newItemInput.focus(), 120)
                                }','xHtml' => '!newItem ? \'New\' : \'Cancel\'']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click' => '() => {
                                    newItem = !newItem;
                                    newItem && setTimeout(() => $refs.newItemInput.focus(), 120)
                                }','x-html' => '!newItem ? \'New\' : \'Cancel\'']); ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div 
                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                            class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2"
                            >
                            <table wire:key="<?php echo e($currentProperty); ?>-oiweqads" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" style="width:20px"></th>
                                        <th scope="col" class="py-3 px-6 text-center">Name</th>
                                        <th scope="col" class="py-3 px-6 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody 
                                    wire:sortable="updateItemOrder"
                                    >
                                    <?php $__currentLoopData = ('App\Models\\' . $currentProperty)::all()->sortBy('position'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr 
                                        wire:sortable.item="<?php echo e($item->id); ?>" 
                                        wire:key="<?php echo e($currentProperty); ?>-<?php echo e($item->id); ?>"
                                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                                        >
                                        <td>
                                            <div wire:sortable.handle class="cursor-grab">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.move','data' => []]); ?>
<?php $component->withName('icons.move'); ?>
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
                                        </td>
                                        <td class="text-center py-2">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inline-edit','data' => ['original' => $item->name,'model' => $currentProperty,'entityId' => $item->id,'field' => 'name','name' => 'dropdown-item']]); ?>
<?php $component->withName('inline-edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['original' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->name),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentProperty),'entityId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->id),'field' => 'name','name' => 'dropdown-item']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </td>
    
                                        <td scope="row">
                                            <div class="w-full flex justify-center">
                                                <div 
                                                    class="text-red-500 hover:underline cursor-pointer text-center" 
                                                    wire:click="delete('<?php echo e($currentProperty); ?>', <?php echo e($item->id); ?>)"
                                                    >
                                                    Delete
                                                </div>
                                            </div>
                                        </td> 
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr x-show="newItem" wire:key="<?php echo e($currentProperty); ?>-newItem">
                                        <td></td>
                                        <td class="py-4 px-6 flex gap-2">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['xRef' => 'newItemInput','wire:model.defer' => 'newItem','type' => 'text']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-ref' => 'newItemInput','wire:model.defer' => 'newItem','type' => 'text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.flat','data' => ['wire:click' => 'createItem(\''.e($currentProperty).'\')','color' => 'green']]); ?>
<?php $component->withName('buttons.flat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'createItem(\''.e($currentProperty).'\')','color' => 'green']); ?>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.check','data' => []]); ?>
<?php $component->withName('icons.check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/settings/components/clients.blade.php ENDPATH**/ ?>