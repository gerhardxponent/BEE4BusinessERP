<div>   
    <div class="w-1/2">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'role-select2','value' => 'Role']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'role-select2','value' => 'Role']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select2','data' => ['options' => $allRoles,'id' => 'roles-select2','wire:model' => 'selectedRole','initial' => ''.e($selectedRole).'']]); ?>
<?php $component->withName('select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allRoles),'id' => 'roles-select2','wire:model' => 'selectedRole','initial' => ''.e($selectedRole).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <a href="../../roles/create" class="text-blue-600 hover:underline">Create new role</a>
    </div>

    <div>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['role' => $roleObject,'user' => $user])->html();
} elseif ($_instance->childHasBeenRendered('l3955767652-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3955767652-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3955767652-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3955767652-0');
} else {
    $response = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['role' => $roleObject,'user' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('l3955767652-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>

    <?php /*
    <div class="user-permissions space-y-2">
        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" class="space-y-3">
            <div class="flex flex-row justify-between items-center">
                <div class="w-1/2">
                    @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'role-select2','value' => 'Role']])
<?php $component->withAttributes(['for' => 'role-select2','value' => 'Role']); ?>
@endComponentClass
                    @component('Illuminate\View\AnonymousComponent', 'select2', ['view' => 'components.select2','data' => ['options' => $allRoles,'id' => 'roles-select2','wire:model' => 'selectedRole','initial' => ''.e($selectedRole).'']])
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allRoles),'id' => 'roles-select2','wire:model' => 'selectedRole','initial' => ''.e($selectedRole).'']); ?>
@endComponentClass
                    <a href="../../roles/create" class="text-blue-600 hover:underline">Create new role</a>
                </div>
                <div>
                    @component('Illuminate\View\AnonymousComponent', 'jet-button', ['view' => 'jetstream::components.button','data' => ['type' => 'submit','class' => 'self-start']])
<?php $component->withAttributes(['type' => 'submit','class' => 'self-start']); ?>Update @endComponentClass
                </div>
            </div>

            <div class="text-sm text-gray-500 flex flex-row gap-1 items-center">
                <div>
                    @component('Illuminate\View\AnonymousComponent', 'icons.info', ['view' => 'components.icons.info','data' => []])
<?php $component->withAttributes([]); ?>
@endComponentClass
                </div>
                <div>Blue ticks are permissions assigned specifically to this user, gray ticks are assigned to all users sharing the above role</div>
            </div>

            <div class="pt-4 space-y-4">
                <div class="space-y-4 bg-white p-4 rounded-xl">
                    <div class="text-xl">Users & Roles</div>

                    <div class="not-prose relative z-0 bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                        <div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
                        <div class="relative rounded-xl overflow-auto">
                            <div class="shadow-sm overflow-hidden my-8">
                                <table class="border-collapse table-auto w-full text-sm">
                                    <thead>
                                        <tr>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Module Name</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Create</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">View</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Edit</th>
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        @foreach($systemPermissions as $module)
                                        <tr>
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ ucwords($module) }}</td>
                                            @foreach($operations as $operation)
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                <div class="form-check form-check-inline">
                                                    <input 
                                                        name="{{ $operation }} {{ $module }}" 
                                                        @if($user->hasPermissionTo($operation . ' ' . $module)) checked @endif 
                                                        @if($roleObject->hasPermissionTo($operation . ' ' . $module)) checked disabled @endif
                                                        
                                                        value="{{ $operation }} {{ $module }}" 
                                                        class="disabled:bg-gray-400 disabled:cursor-not-allowed form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                                        type="checkbox" 
                                                    />
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
                    </div>
                </div>
            </div>
            
            <div class="pt-4 space-y-4">
                <div class="space-y-2 bg-white p-4 rounded-xl">
                    <div class="text-xl">Management</div>

                    <div class="flex flex-row items-center gap-1 mb-4">
                        @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'management','value' => 'Full access to management module']])
<?php $component->withAttributes(['for' => 'management','value' => 'Full access to management module']); ?>
@endComponentClass
                        <input 
                            name="management" 
                            @if($user->hasPermissionTo('access management')) checked @endif 
                            @if($roleObject->hasPermissionTo('access management')) checked disabled @endif
                            value='access management' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="management" 
                        />
                    </div>
                </div>

                <div class="space-y-2 bg-white p-4 rounded-xl">
                    <div class="text-xl">Tasks</div>
    
                    <div class="flex flex-row items-center gap-1 mb-4">
                        @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'tasks','value' => 'View all users tasks']])
<?php $component->withAttributes(['for' => 'tasks','value' => 'View all users tasks']); ?>
@endComponentClass
                        <input 
                            name="tasks" 
                            @if($user->hasPermissionTo('view all tasks')) checked @endif 
                            @if($roleObject->hasPermissionTo('view all tasks')) checked disabled @endif
                            value='view all tasks' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="tasks" 
                        />
                    </div>
                </div>

                <div class="space-y-2 bg-white p-4 rounded-xl">
                    <div class="text-xl">Projects</div>
    
                    <div class="w-1/2 space-y-1">
                        <div class="text-sm text-gray-500 flex flex-row gap-1 items-center mb-2">
                            <div>
                                @component('Illuminate\View\AnonymousComponent', 'icons.info', ['view' => 'components.icons.info','data' => []])
<?php $component->withAttributes([]); ?>
@endComponentClass
                            </div>
                            <div>Control user access to client project phases</div>
                        </div>

                        @foreach ($phases as $phase)
                        <div class="grid grid-cols-2 items-center gap-1">
                            @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => ''.e($phase).'','value' => ''.e($phase->name).'']])
<?php $component->withAttributes(['for' => ''.e($phase).'','value' => ''.e($phase->name).'']); ?>
@endComponentClass
                            <input 
                                name="{{ $phase->name }}" 
                                @if($user->hasPermissionTo('view ' . $phase->name)) checked @endif 
                                @if($roleObject->hasPermissionTo('view ' . $phase->name)) checked disabled @endif
                                value="view {{ $phase->name }}"
                                class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                type="checkbox" 
                                id="{{ $phase->name }}" 
                            />
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-2 bg-white p-4 rounded-xl">
                    <div class="text-xl">Modules</div>
                    <div class="space-y-2">
                        <div id="permissions-table" class="not-prose relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25">
                            <div style="background-position:10px 10px" class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]"></div>
                            <div class="relative rounded-xl overflow-auto">
                                <div class="shadow-sm overflow-hidden my-8">
                                    <table class="border-collapse table-auto w-full text-sm">
                                        <thead>
                                            <tr>
                                                <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Module Name</th>
                                                <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Create</th>
                                                <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">View</th>
                                                <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Edit</th>
                                                <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-slate-800">
                                            @foreach($modules as $moduleIndex => $module)
                                            <tr>
                                                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ ucwords($module->name) }}</td>
                                                @foreach($operations as $operationIndex => $operation)
                                                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="form-check form-check-inline">
                                                        <input 
                                                            name="{{ $operation . ' ' . $module->name }}" 
                                                            @if($user->hasPermissionTo($operation . ' ' . $module->name)) checked @endif 
                                                            @if($roleObject->hasPermissionTo($operation . ' ' . $module->name)) checked disabled @endif
                                                            value="{{ $operation . ' ' . $module->name }}" 
                                                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                                            type="checkbox" 
                                                            id="inlineCheckbox2" 
                                                        />
                                                    </div>
                                                </td>
                                                @endforeach
                                            </tr>        
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    */ ?>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/livewire/users/components/permissions.blade.php ENDPATH**/ ?>