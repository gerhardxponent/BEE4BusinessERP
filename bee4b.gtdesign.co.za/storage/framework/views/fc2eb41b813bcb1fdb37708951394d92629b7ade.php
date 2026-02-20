<div class="relative">
    <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
        
        <div class="permissions-header bg-indigo-500 text-white p-4 shadow-lg transition-all mb-3 text-xl font-bold flex justify-between items-center  rounded-xl sticky top-0 left-0 z-[9999]">
            <div><?php echo e($title); ?></div>
            <div class="flex gap-1">
                <?php if(isset($role) && !isset($user)): ?>
                    <?php if($role->name != 'administrator' && $role->name != 'Administrator'): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['xOn:click.prevent' => 'Livewire.emit(\'confirmDelete\')']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click.prevent' => 'Livewire.emit(\'confirmDelete\')']); ?>Delete <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'submit']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'submit']); ?>
                    <?php if(isset($role) || isset($user)): ?>
                        Update
                    <?php else: ?>
                        Create
                    <?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        </div>
        
        <?php if(!isset($role) && !isset($user)): ?>
        <div class="w-1/4 bg-white p-4 rounded-lg mb-4">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'role-name','value' => 'Role name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'role-name','value' => 'Role name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['wire:model.defer' => 'roleName','type' => 'text']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model.defer' => 'roleName','type' => 'text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="space-y-3">
            
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Users & Roles</div>

                <div class="space-y-1">
                    <div class="not-prose relative  bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                        <div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
                        <div class="relative rounded-xl overflow-auto">
                            <div class="shadow-sm overflow-hidden my-8">
                                <table class="border-collapse table-auto w-full text-sm">
                                    <thead>
                                        <tr>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Module Name</th>
                                            <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.checkbox','data' => ['wire:model' => 'usersAndRolesCheckboxes.'.e($operation).'']]); ?>
<?php $component->withName('jet-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'usersAndRolesCheckboxes.'.e($operation).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                <span><?php echo e($operation); ?></span>
                                            </th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        <?php $__currentLoopData = $systemPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outer => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.checkbox','data' => ['wire:model' => 'systemPermissionCheck.'.e($outer).'.checked']]); ?>
<?php $component->withName('jet-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'systemPermissionCheck.'.e($outer).'.checked']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                <span><?php echo e(ucwords($module)); ?></span>
                                            </td>
                                            <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inner => $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                        name="<?php echo e($operation); ?> <?php echo e($module); ?>" 
                                                        value="<?php echo e($operation); ?> <?php echo e($module); ?>" 
                                                        class="disabled:bg-gray-400 disabled:cursor-not-allowed form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                                        type="checkbox" 
                                                        
                                                        <?php if($usersAndRolesCheckboxes[$operation]): ?> checked <?php endif; ?>
                                                        <?php if(isset($systemPermissionCheck[$outer]['checked']) && $systemPermissionCheck[$outer]['checked'] === true): ?> checked <?php endif; ?>
                                                        
                                                        <?php if(isset($role) && $role->hasPermissionTo($operation . ' ' . $module)): ?> checked <?php endif; ?>
                                                        <?php if(isset($user) && $user->hasPermissionTo($operation . ' ' . $module)): ?> checked <?php endif; ?>
                                                        <?php if(isset($user) && isset($role) && $role->hasPermissionTo($operation . ' ' . $module)): ?> checked disabled <?php endif; ?>
                                                    />
                                                </div>
                                            </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
                    </div>
                </div>
            </div>
            

            
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Management</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'management','value' => 'Full access to management module']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'management','value' => 'Full access to management module']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <input 
                            name="management" 
                            value='access management' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="management" 
                            
                            <?php if(isset($role) && $role->hasPermissionTo('access management')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && $user->hasPermissionTo('access management')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && isset($role) && $role->hasPermissionTo('access management')): ?> checked disabled <?php endif; ?>
                        />
                    </div>
                </div>
            </div>
            

            
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Audits</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'audits','value' => 'View last checked on audit files']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'audits','value' => 'View last checked on audit files']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <input 
                            name="audits" 
                            value='view last checked' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="audits" 
                            
                            <?php if(isset($role) && $role->hasPermissionTo('view last checked')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && $user->hasPermissionTo('view last checked')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && isset($role) && $role->hasPermissionTo('view last checked')): ?> checked disabled <?php endif; ?>
                        />
                    </div>
                </div>
            </div>
            

            
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Tasks</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'tasks','value' => 'View all users tasks']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'tasks','value' => 'View all users tasks']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <input 
                            name="tasks" 
                            value='view all tasks' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="tasks" 
                            
                            <?php if(isset($role) && $role->hasPermissionTo('view all tasks')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && $user->hasPermissionTo('view all tasks')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && isset($role) && $role->hasPermissionTo('view all tasks')): ?> checked disabled <?php endif; ?>
                        />
                    </div>
                </div>
            </div>
            

            
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Projects</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1 mb-4">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'view-all-projects','value' => 'View all projects']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'view-all-projects','value' => 'View all projects']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <input
                            name="view-all-projects" 
                            value="view all projects"
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="view-all-projects" 
                            
                            <?php if(isset($role) && $role->hasPermissionTo('view all projects')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && $user->hasPermissionTo('view all projects')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && isset($role) && $role->hasPermissionTo('view all projects')): ?> checked disabled <?php endif; ?>
                        />
                        <div class="text-red-500">
                            <div class="text-xs">This permission will grant the user access to all the clients, as well as all the projects for each client</div>
                        </div>                
                    </div>

                    <div class="grid grid-cols-2 items-center gap-1 mb-4">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'reorder-tasks','value' => 'Reorder Tasks']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'reorder-tasks','value' => 'Reorder Tasks']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <input
                            name="reorder-tasks" 
                            value="reorder tasks"
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="reorder-tasks" 
                            
                            <?php if(isset($role) && $role->hasPermissionTo('reorder tasks')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && $user->hasPermissionTo('reorder tasks')): ?> checked <?php endif; ?>
                            <?php if(isset($user) && isset($role) && $role->hasPermissionTo('reorder tasks')): ?> checked disabled <?php endif; ?>
                        />                        
                    </div>

                    <?php $__currentLoopData = \App\Models\Phase::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="grid grid-cols-2 items-center gap-1">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => ''.e($phase).'','value' => ''.e($phase->name).'']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => ''.e($phase).'','value' => ''.e($phase->name).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <input 
                            name="<?php echo e($phase->name); ?>" 
                            value="view <?php echo e($phase->name); ?>"
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="<?php echo e($phase->name); ?>" 
                            
                            <?php if(isset($role) && $role->hasPermissionTo('view ' . $phase->name)): ?> checked <?php endif; ?>
                            <?php if(isset($user) && $user->hasPermissionTo('view ' . $phase->name)): ?> checked <?php endif; ?>
                            <?php if(isset($user) && isset($role) && $role->hasPermissionTo('view ' . $phase->name)): ?> checked disabled <?php endif; ?>
                        />
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            

            
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Modules</div>

                <div class="not-prose relative z-0 bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                    <div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
                    <div class="relative rounded-xl overflow-auto">
                        <div class="shadow-sm overflow-hidden my-8">
                            <table class="border-collapse table-auto w-full text-sm">
                                <thead>
                                    <tr>
                                        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Module Name</th>
                                        <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.checkbox','data' => ['wire:model' => 'modulesCheckboxes.'.e($operation).'']]); ?>
<?php $component->withName('jet-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'modulesCheckboxes.'.e($operation).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                <span><?php echo e($operation); ?></span>
                                            </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800">
                                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.checkbox','data' => ['wire:model' => 'modules.'.e($index).'.checked']]); ?>
<?php $component->withName('jet-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'modules.'.e($index).'.checked']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <span><?php echo e(ucwords($module->name)); ?></span>
                                        </td>
                                        <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                            <div class="form-check form-check-inline">
                                                <input 
                                                    name="<?php echo e($operation); ?> <?php echo e($module->name); ?>" 
                                                    value="<?php echo e($operation); ?> <?php echo e($module->name); ?>" 
                                                    class="disabled:bg-gray-400 disabled:cursor-not-allowed form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                                    type="checkbox" 
                                                    
                                                    
                                                    <?php if($modulesCheckboxes[$operation] || $module->checked): ?> checked <?php endif; ?>
                                                    <?php if(isset($role) && $role->hasPermissionTo($operation . ' ' . $module->name)): ?> checked <?php endif; ?> 
                                                    
                                                    <?php if(isset($role) && $role->hasPermissionTo($operation . ' ' . $module->name)): ?> checked <?php endif; ?>
                                                    <?php if(isset($user) && $user->hasPermissionTo($operation . ' ' . $module->name)): ?> checked <?php endif; ?>
                                                    <?php if(isset($user) && isset($role) && $role->hasPermissionTo($operation . ' ' . $module->name)): ?> checked disabled <?php endif; ?>
                                                />
                                            </div>
                                        </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
                </div>
            </div>
            
        </div>
    </form>

    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.confirmation-modal','data' => ['wire:model' => 'showConfirmDeleteModal']]); ?>
<?php $component->withName('jet-confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showConfirmDeleteModal']); ?>
         <?php $__env->slot('title', null, []); ?> Delete role <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> Are you sure you would like to delete this role? <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-1 items-center">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['xOn:click' => 'show = false']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click' => 'show = false']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.delete-button','data' => ['wire:click' => 'deleteRole']]); ?>
<?php $component->withName('buttons.delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'deleteRole']); ?>Delete <?php echo $__env->renderComponent(); ?>
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
    

    <script>
        // const headerEl = document.querySelector('.permissions-header');
        // const sentialEl = document.querySelector('.sential');

        // const handler = (entries) => {
        //     if (!entries[0].isIntersecting) {
        //         headerEl.classList.add('bg-indigo-500', 'text-white', 'shadow-lg', 'p-4');
        //     } else {
        //         headerEl.classList.remove('bg-indigo-500', 'text-white', 'shadow-lg', 'p-4');
        //     }
        // }

        // const observer = new window.IntersectionObserver(handler);
        // observer.observe(sentialEl);
    </script>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/livewire/global-components/roles-and-permissions.blade.php ENDPATH**/ ?>