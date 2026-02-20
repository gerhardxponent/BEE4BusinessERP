<div>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-4">
            <div class="bg-white p-8 rounded-lg">
                <table class="table-fixed">
                    <tr>
                        <td class="font-bold">Name</td>
                        <?php if($editing): ?>
                        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'user.name']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'user.name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        <?php else: ?>
                        <td><?php echo e($user->name); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td class="font-bold">Email</td>
                        <?php if($editing): ?>
                        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'user.email']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'user.email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        <?php else: ?>
                        <td><?php echo e($user->email); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td class="font-bold">Role 1</td>
                        <?php if($editing): ?>
                        <td>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select2','data' => ['options' => $allRoles,'id' => 'roles-select2-1','wire:model' => 'selectedRole1','initial' => ''.e($user->roles[0]->id).'']]); ?>
<?php $component->withName('select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allRoles),'id' => 'roles-select2-1','wire:model' => 'selectedRole1','initial' => ''.e($user->roles[0]->id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </td>
                        <?php else: ?>
                        <td>
                            <span wire:click="$emit('changeTab', 'permissions')" class="cursor-pointer text-blue-600 hover:underline">
                                <?php echo e($user->roles[0]->name); ?>

                            </span>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td class="font-bold">Role 2</td>
                        <?php if($editing): ?>
                        <td>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select2','data' => ['options' => $allRoles,'id' => 'roles-select2-2','wire:model' => 'selectedRole2','initial' => ''.e($user->roles[1]->id ?? '').'']]); ?>
<?php $component->withName('select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allRoles),'id' => 'roles-select2-2','wire:model' => 'selectedRole2','initial' => ''.e($user->roles[1]->id ?? '').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </td>
                        <?php else: ?>
                        <td>
                            <?php if(isset($user->roles[1])): ?>  <!-- Check if the second role exists -->
                                <span wire:click="$emit('changeTab', 'permissions')" class="cursor-pointer text-blue-600 hover:underline">
                                    <?php echo e($user->roles[1]->name); ?>

                                </span>
                            <?php else: ?>
                                <span>No second role assigned</span> <!-- Display a fallback message if no second role -->
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <td class="font-bold">Address</td>
                        <?php if($editing): ?>
                        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'user.street_address']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'user.street_address']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        <?php else: ?>
                        <td><?php echo e($user->street_address); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td class="font-bold">Postal Code</td>
                        <?php if($editing): ?>
                        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'user.postal_code']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'user.postal_code']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        <?php else: ?>
                        <td><?php echo e($user->postal_code); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td class="font-bold">City</td>
                        <?php if($editing): ?>
                        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'user.city']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'user.city']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        <?php else: ?>
                        <td><?php echo e($user->city); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td class="font-bold">Province</td>
                        <?php if($editing): ?>
                        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'user.province']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'user.province']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        <?php else: ?>
                        <td><?php echo e($user->province); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td class="font-bold">Country</td>
                        <?php if($editing): ?>
                        <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'user.country']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'user.country']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        <?php else: ?>
                        <td><?php echo e($user->country); ?></td>
                        <?php endif; ?>
                    </tr>
                </table>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="bg-white p-8 rounded-lg space-y-4">
                <div class="flex flex-row justify-between items-center">
                    <div class="font-bold text-lg">Recently uploaded files</div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.flat','data' => ['wire:click' => '$emit(\'changeTab\', \'files\')']]); ?>
<?php $component->withName('buttons.flat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$emit(\'changeTab\', \'files\')']); ?>
                        <div>View All</div>
                         <?php $__env->slot('trailingIcon', null, []); ?> <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.right-arrow','data' => []]); ?>
<?php $component->withName('icons.right-arrow'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>

                <div 
                    style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                    class="overflow-x-auto relative sm:rounded-lg shadow-xl"
                    >
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    File name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Type
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Size
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Uploaded on
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $user->files()->orderByDesc('created_at')->paginate(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <td class="py-4 px-6">
                                    <?php echo e($file->file_name); ?>

                                </td>
                                <td class="py-4 px-6">
                                    <?php echo e($file->type); ?>

                                </td>
                                <td class="py-4 px-6">
                                    <?php echo e($file->file_size); ?>

                                </td>
                                <td class="py-4 px-6">
                                    <?php echo e($file->created_at->format('d/m/Y')); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/livewire/users/components/overview.blade.php ENDPATH**/ ?>