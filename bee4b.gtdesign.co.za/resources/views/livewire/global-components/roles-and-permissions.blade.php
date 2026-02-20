<div class="relative">
    <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
        {{-- <div class="sential w-full h-1 opacity-0"></div> --}}
        <div class="permissions-header bg-indigo-500 text-white p-4 shadow-lg transition-all mb-3 text-xl font-bold flex justify-between items-center  rounded-xl sticky top-0 left-0 z-[9999]">
            <div>{{ $title }}</div>
            <div class="flex gap-1">
                @if(isset($role) && !isset($user))
                    @if($role->name != 'administrator' && $role->name != 'Administrator')
                    <x-jet-button x-on:click.prevent="Livewire.emit('confirmDelete')">Delete</x-jet-button>
                    @endif
                @endif
                <x-jet-button type="submit">
                    @if(isset($role) || isset($user))
                        Update
                    @else
                        Create
                    @endif
                </x-jet-button>
            </div>
        </div>
        
        @if(!isset($role) && !isset($user))
        <div class="w-1/4 bg-white p-4 rounded-lg mb-4">
            <x-jet-label for="role-name" value="Role name" />
            <x-jet-input wire:model.defer="roleName" type="text" />
        </div>
        @endif

        <div class="space-y-3">
            {{-- Users & Roles --}}
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
                                            @foreach ($operations as $operation)
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                <x-jet-checkbox wire:model="usersAndRolesCheckboxes.{{ $operation }}" />
                                                <span>{{ $operation }}</span>
                                            </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        @foreach($systemPermissions as $outer => $module)
                                        <tr>
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                <x-jet-checkbox wire:model="systemPermissionCheck.{{ $outer }}.checked" />
                                                <span>{{ ucwords($module) }}</span>
                                            </td>
                                            @foreach($operations as $inner => $operation)
                                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                        name="{{ $operation }} {{ $module }}" 
                                                        value="{{ $operation }} {{ $module }}" 
                                                        class="disabled:bg-gray-400 disabled:cursor-not-allowed form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                                        type="checkbox" 
                                                        {{-- For group selection --}}
                                                        @if($usersAndRolesCheckboxes[$operation]) checked @endif
                                                        @if(isset($systemPermissionCheck[$outer]['checked']) && $systemPermissionCheck[$outer]['checked'] === true) checked @endif
                                                        {{-- If user or users role already has permission --}}
                                                        @if(isset($role) && $role->hasPermissionTo($operation . ' ' . $module)) checked @endif
                                                        @if(isset($user) && $user->hasPermissionTo($operation . ' ' . $module)) checked @endif
                                                        @if(isset($user) && isset($role) && $role->hasPermissionTo($operation . ' ' . $module)) checked disabled @endif
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
            {{-- End users & roles --}}

            {{-- Management --}}
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Management</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1">
                        <x-jet-label for="management" value="Full access to management module" />
                        <input 
                            name="management" 
                            value='access management' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="management" 
                            {{-- If user or users role already has permission --}}
                            @if(isset($role) && $role->hasPermissionTo('access management')) checked @endif
                            @if(isset($user) && $user->hasPermissionTo('access management')) checked @endif
                            @if(isset($user) && isset($role) && $role->hasPermissionTo('access management')) checked disabled @endif
                        />
                    </div>
                </div>
            </div>
            {{-- End management --}}

            {{-- Audits --}}
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Audits</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1">
                        <x-jet-label for="audits" value="View last checked on audit files" />
                        <input 
                            name="audits" 
                            value='view last checked' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="audits" 
                            {{-- If user or users role already has permission --}}
                            @if(isset($role) && $role->hasPermissionTo('view last checked')) checked @endif
                            @if(isset($user) && $user->hasPermissionTo('view last checked')) checked @endif
                            @if(isset($user) && isset($role) && $role->hasPermissionTo('view last checked')) checked disabled @endif
                        />
                    </div>
                </div>
            </div>
            {{-- End audits --}}

            {{-- Tasks --}}
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Tasks</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1">
                        <x-jet-label for="tasks" value="View all users tasks" />
                        <input 
                            name="tasks" 
                            value='view all tasks' 
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="tasks" 
                            {{-- If user or users role already has permission --}}
                            @if(isset($role) && $role->hasPermissionTo('view all tasks')) checked @endif
                            @if(isset($user) && $user->hasPermissionTo('view all tasks')) checked @endif
                            @if(isset($user) && isset($role) && $role->hasPermissionTo('view all tasks')) checked disabled @endif
                        />
                    </div>
                </div>
            </div>
            {{-- End tasks --}}

            {{-- Projects --}}
            <div class="space-y-2 bg-white p-4 rounded-xl">
                <div class="text-xl">Projects</div>

                <div class="w-1/2">
                    <div class="grid grid-cols-2 items-center gap-1 mb-4">
                        <x-jet-label for="view-all-projects" value="View all projects" />
                        <input
                            name="view-all-projects" 
                            value="view all projects"
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="view-all-projects" 
                            {{-- If user or users role already has permission --}}
                            @if(isset($role) && $role->hasPermissionTo('view all projects')) checked @endif
                            @if(isset($user) && $user->hasPermissionTo('view all projects')) checked @endif
                            @if(isset($user) && isset($role) && $role->hasPermissionTo('view all projects')) checked disabled @endif
                        />
                        <div class="text-red-500">
                            <div class="text-xs">This permission will grant the user access to all the clients, as well as all the projects for each client</div>
                        </div>                
                    </div>

                    <div class="grid grid-cols-2 items-center gap-1 mb-4">
                        <x-jet-label for="reorder-tasks" value="Reorder Tasks" />
                        <input
                            name="reorder-tasks" 
                            value="reorder tasks"
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="reorder-tasks" 
                            {{-- If user or users role already has permission --}}
                            @if(isset($role) && $role->hasPermissionTo('reorder tasks')) checked @endif
                            @if(isset($user) && $user->hasPermissionTo('reorder tasks')) checked @endif
                            @if(isset($user) && isset($role) && $role->hasPermissionTo('reorder tasks')) checked disabled @endif
                        />                        
                    </div>

                    @foreach (\App\Models\Phase::all() as $phase)
                    <div class="grid grid-cols-2 items-center gap-1">
                        <x-jet-label for="{{ $phase }}" value="{{ $phase->name }}" />
                        <input 
                            name="{{ $phase->name }}" 
                            value="view {{ $phase->name }}"
                            class="disabled:bg-gray-400 disabled:cursor-not-allowed  form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                            type="checkbox" 
                            id="{{ $phase->name }}" 
                            {{-- If user or users role already has permission --}}
                            @if(isset($role) && $role->hasPermissionTo('view ' . $phase->name)) checked @endif
                            @if(isset($user) && $user->hasPermissionTo('view ' . $phase->name)) checked @endif
                            @if(isset($user) && isset($role) && $role->hasPermissionTo('view ' . $phase->name)) checked disabled @endif
                        />
                    </div>
                    @endforeach
                </div>
            </div>
            {{-- End projects --}}

            {{-- Modules --}}
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
                                        @foreach ($operations as $operation)
                                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                                                <x-jet-checkbox wire:model="modulesCheckboxes.{{ $operation }}" />
                                                <span>{{ $operation }}</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800">
                                    @foreach($modules as $index => $module)
                                    <tr>
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                            <x-jet-checkbox wire:model="modules.{{ $index }}.checked" />
                                            <span>{{ ucwords($module->name) }}</span>
                                        </td>
                                        @foreach($operations as $operation)
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                            <div class="form-check form-check-inline">
                                                <input 
                                                    name="{{ $operation }} {{ $module->name }}" 
                                                    value="{{ $operation }} {{ $module->name }}" 
                                                    class="disabled:bg-gray-400 disabled:cursor-not-allowed form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer " 
                                                    type="checkbox" 
                                                    {{-- id="inlineCheckbox2"  --}}
                                                    {{-- For group selection --}}
                                                    @if($modulesCheckboxes[$operation] || $module->checked) checked @endif
                                                    @if(isset($role) && $role->hasPermissionTo($operation . ' ' . $module->name)) checked @endif 
                                                    {{-- If user or users role already has permission --}}
                                                    @if(isset($role) && $role->hasPermissionTo($operation . ' ' . $module->name)) checked @endif
                                                    @if(isset($user) && $user->hasPermissionTo($operation . ' ' . $module->name)) checked @endif
                                                    @if(isset($user) && isset($role) && $role->hasPermissionTo($operation . ' ' . $module->name)) checked disabled @endif
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
            {{-- End modules --}}
        </div>
    </form>

    {{-- MODALS --}}
    <x-jet-confirmation-modal wire:model="showConfirmDeleteModal">
        <x-slot name="title">Delete role</x-slot>
        <x-slot name="content">Are you sure you would like to delete this role?</x-slot>
        <x-slot name="footer">
            <div class="flex gap-1 items-center">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-buttons.delete-button wire:click="deleteRole">Delete</x-buttons.delete-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>
    {{-- END MODALS --}}

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
