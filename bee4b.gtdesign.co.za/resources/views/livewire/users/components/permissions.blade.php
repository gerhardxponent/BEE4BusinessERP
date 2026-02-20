<div>   
    <div class="w-1/2">
        <x-jet-label for="role-select2" value="Role" />
        <x-select2 
            :options="$allRoles" 
            id="roles-select2" 
            wire:model="selectedRole" 
            initial="{{ $selectedRole }}" 
        />
        <a href="../../roles/create" class="text-blue-600 hover:underline">Create new role</a>
    </div>

    <div>
        <livewire:global-components.roles-and-permissions :role="$roleObject" :user="$user" />
    </div>

    <?php /*
    <div class="user-permissions space-y-2">
        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" class="space-y-3">
            <div class="flex flex-row justify-between items-center">
                <div class="w-1/2">
                    <x-jet-label for="role-select2" value="Role" />
                    <x-select2 
                        :options="$allRoles" 
                        id="roles-select2" 
                        wire:model="selectedRole" 
                        initial="{{ $selectedRole }}" 
                    />
                    <a href="../../roles/create" class="text-blue-600 hover:underline">Create new role</a>
                </div>
                <div>
                    <x-jet-button type="submit" class="self-start">Update</x-jet-button>
                </div>
            </div>

            <div class="text-sm text-gray-500 flex flex-row gap-1 items-center">
                <div>
                    <x-icons.info />
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
                                                        {{-- @if($role->name === 'Administrator') checked disabled @endif --}}
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
                        <x-jet-label for="management" value="Full access to management module" />
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
                        <x-jet-label for="tasks" value="View all users tasks" />
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
                                <x-icons.info />
                            </div>
                            <div>Control user access to client project phases</div>
                        </div>

                        @foreach ($phases as $phase)
                        <div class="grid grid-cols-2 items-center gap-1">
                            <x-jet-label for="{{ $phase }}" value="{{ $phase->name }}" />
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
