@php
    $canDelete = !auth()->user()->hasAnyRole(['Client','Client Sub User']);
    $canChangeStatus = !auth()->user()->hasAnyRole(['Client','Client Sub User']);
    $canAssignResponsible = !auth()->user()->hasRole('Client Sub User');
@endphp

    <div class="relative audit-details-page">
        <style>
            .audit-details-page .select2-container,
            .select2-container { z-index: 2147483647 !important; position: relative; }
            .audit-details-page .select2-dropdown,
            .select2-dropdown { z-index: 2147483647 !important; }
            .audit-details-page .select2-container--default .select2-selection--single,
            .audit-details-page .select2-container--default .select2-selection--multiple,
            .select2-container--default .select2-selection--single,
            .select2-container--default .select2-selection--multiple {
                min-height: 42px !important;
            }
            .audit-details-page .select2-container--default .select2-selection--single .select2-selection__rendered,
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 42px !important;
                padding-left: 8px;
            }
            .audit-details-page .select2-container--default .select2-selection--single .select2-selection__arrow,
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 42px !important;
                top: 0 !important;
                right: 6px;
            }
            .audit-details-page .select2-search__field,
            .select2-search__field {
                min-height: 30px !important;
                line-height: 30px !important;
            }

            /* Tidy up native selects so folder-level dropdowns look consistent */
            .audit-details-page select,
            .audit-details-page .form-select {
                min-height: 42px;
                line-height: 42px;
                padding: 6px 10px;
                border: 1px solid #d1d5db; /* tailwind gray-300 */
                border-radius: 8px;
                background-color: #fff;
            }

            /* Make inline folder-level selects a comfortable width */
            .audit-details-page .folder-header select,
            .audit-details-page .folder-actions select,
            .audit-details-page .assign-responsible select,
            .audit-details-page .folder-header .select2-container,
            .audit-details-page .folder-actions .select2-container,
            .audit-details-page .assign-responsible .select2-container {
                display: inline-block;
                min-width: 180px;
                max-width: 220px;
                height: 36px;
                line-height: 36px;
                font-size: 0.875rem;
                margin-left: 8px;
                width: auto !important;
            }

            /* Lay out the header actions on one line (Add Item + Assign) */
            .audit-details-page .folder-header,
            .audit-details-page .folder-actions,
            .audit-details-page .assign-responsible,
            .audit-details-page .folder-top,
            .audit-details-page .category-header,
            .audit-details-page .category-topbar {
                display: flex;
                align-items: center;
                gap: 8px;
                justify-content: flex-end;
            }

            /* Ensure the Add Item button sits right next to the dropdown */
            .audit-details-page .folder-header .add-item,
            .audit-details-page .folder-header .btn,
            .audit-details-page .folder-actions .btn {
                height: 36px;
                padding: 0 10px;
                line-height: 36px;
            }

            /* If a full-width style sneaks in, override aggressively */
            .audit-details-page .folder-header select.w-full,
            .audit-details-page .folder-header .select2-container[style*="width"],
            .audit-details-page .assign-responsible .select2-container[style*="width"],
            .audit-details-page .folder-actions .select2-container[style*="width"] {
                width: 220px !important;
            }

            /* Ensure any dropdown (native or select2) overlays headers */
            .audit-details-page .select2-container--open,
            .audit-details-page select:focus {
                position: relative;
                z-index: 2147483647 !important;
                outline: none;
                box-shadow: 0 0 0 3px rgba(59,130,246,0.25); /* focus ring */
                border-color: #3b82f6; /* blue-500 */
            }

            /* Force compact width for header area specifically */
            .audit-details-page .bg-gray-700 .select2,
            .audit-details-page .bg-gray-700 .select2-container,
            .audit-details-page .bg-gray-700 select {
                width: 220px !important;
                max-width: 220px !important;
                min-width: 180px;
            }
        </style>
        <x-toast.success-event />

        <div class="fixed z-50 top-20 right-5 space-y-4">
            @if (session()->has('message'))
            <x-toast.success message="{{ session('message') }}"></x-toast.success>
            @endif
        </div>

    @php
        // Calculate the total number of files to be audited (uploaded + not uploaded yet)
        $totalFilesAndEmpty = $this->auditSummary['totalFiles'] + $this->auditSummary['totalEmpty'];

        // Define the percentages for each status, handling division by zero
        $acceptedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalAccepted'] / $totalFilesAndEmpty) * 100) : 0;
        $pendingPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalPending'] / $totalFilesAndEmpty) * 100) : 0;
        $rejectedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalRejected'] / $totalFilesAndEmpty) * 100) : 0;
        $emptyPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalEmpty'] / $totalFilesAndEmpty) * 100) : 0;
    @endphp

    @php
        // Calculate the total number of files to be audited (uploaded + not uploaded yet)
        $totalFilesAndEmpty = $this->auditSummary['totalFiles'] + $this->auditSummary['totalEmpty'];

        // Define the percentages for each status, handling division by zero
        $acceptedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalAccepted'] / $totalFilesAndEmpty) * 100) : 0;
        $pendingPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalPending'] / $totalFilesAndEmpty) * 100) : 0;
        $rejectedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalRejected'] / $totalFilesAndEmpty) * 100) : 0;
        $emptyPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalEmpty'] / $totalFilesAndEmpty) * 100) : 0;
    @endphp

    @php
        // Calculate the total number of files to be audited (uploaded + not uploaded yet)
        $totalFilesAndEmpty = $this->auditSummary['totalFiles'] + $this->auditSummary['totalEmpty'];

        // Define the percentages for each status, handling division by zero
        $acceptedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalAccepted'] / $totalFilesAndEmpty) * 100) : 0;
        $pendingPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalPending'] / $totalFilesAndEmpty) * 100) : 0;
        $rejectedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalRejected'] / $totalFilesAndEmpty) * 100) : 0;
        $emptyPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalEmpty'] / $totalFilesAndEmpty) * 100) : 0;
    @endphp

    <div id="auditSummary" class="p-6 border bg-white rounded-lg shadow-lg text-lg">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-bold">Audit Summary</h2>
                <div class="flex items-center gap-2">
                    <x-jet-button type="button" x-data x-on:click="$wire.set('showNewCategoryModal', true)">Add Category</x-jet-button>
                </div>
            </div>

        <div class="mt-2 text-sm text-gray-700 flex flex-wrap items-center gap-x-3 gap-y-2">
            <div class="font-semibold">Total: {{ $totalFilesAndEmpty }}</div>
            <span class="text-gray-400">·</span>
            <div class="text-emerald-600 font-semibold">Accepted {{ $acceptedPercent }}%</div>
            <span class="text-gray-400">·</span>
            <div class="font-semibold" style="color:orange">Pending {{ $pendingPercent }}%</div>
            <span class="text-gray-400">·</span>
            <div class="text-red-600 font-semibold">Rejected {{ $rejectedPercent }}%</div>
            <span class="text-gray-400">·</span>
            <div class="text-gray-600 font-semibold">Not Uploaded {{ $emptyPercent }}%</div>
        </div>

        @if ($totalFilesAndEmpty > 0)
            <div class="flex h-4 w-full rounded-full overflow-hidden mt-2">
                {{-- Accepted Segment (Green) --}}
                <div
                    class="bg-green-500 flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: {{ $acceptedPercent }}%;"
                >
                    @if ($acceptedPercent > 5) {{ $acceptedPercent }}% @endif
                </div>

                {{-- Pending Segment (Yellow) --}}
                <div
                    class="bg-yellow-500 min-w-[0.5rem] flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: {{ $pendingPercent }}%;  background-color:orange !important;"
                >
                    @if ($pendingPercent > 5) {{ $pendingPercent }}% @endif
                </div>

                {{-- Rejected Segment (Red) --}}
                <div
                    class="bg-red-500 flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: {{ $rejectedPercent }}%;"
                >
                    @if ($rejectedPercent > 5) {{ $rejectedPercent }}% @endif
                </div>

                {{-- Empty Segment (Grey) --}}
                <div
                    class="bg-gray-400 flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: {{ $emptyPercent }}%;"
                >
                    @if ($emptyPercent > 5) {{ $emptyPercent }}% @endif
                </div>
            </div>
        @else
            <div class="text-gray-500 text-center py-4 mt-4">
                No files to audit.
            </div>
        @endif
    </div>

    <br/><br/>

    <!-- 🔹 Add Search Input Box -->
    <div class="mb-4 flex flex-col md:flex-row md:items-end md:space-x-4">
        <!-- Search Text Input -->
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Search</label>
            <input 
                type="text" 
                wire:model.debounce.300ms="searchString" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
                placeholder="Search categories or items..."
            />
        </div>

        <!-- Responsible User Dropdown Filter -->
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Responsible User</label>
            <select
                x-data
                wire:ignore
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
                x-init="$nextTick(() => {
                    const $jq = window.jQuery || window.$;
                    if (!$jq) return;
                    const inst = $jq($el).select2({
                        width: '100%',
                        dropdownParent: $jq('body'),
                        placeholder: 'All Users'
                    });
                    inst.val(@js($filterUser ?? '')).trigger('change.select2');
                    inst.on('change', e => $wire.set('filterUser', e.target.value));
                })"
            >
                <option value="">All Users</option>
                @foreach ($this->getUsersWithAssignedFilesForThisAuditProperty() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status Dropdown -->
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select
                x-data
                wire:ignore
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
                x-init="$nextTick(() => {
                    const $jq = window.jQuery || window.$;
                    if (!$jq) return;
                    const inst = $jq($el).select2({
                        width: '100%',
                        dropdownParent: $jq('body'),
                        placeholder: 'All Statuses'
                    });
                    inst.val(@js($filterStatus ?? '')).trigger('change.select2');
                    inst.on('change', e => $wire.set('filterStatus', e.target.value));
                })"
            >
                <option value="">All Statuses</option>
                <option value="0:pending">Pending</option>
                <option value="0:waiting">Waiting for upload</option>
                <option value="1">Accepted</option>
                <option value="2">Rejected</option>
            </select>
        </div>
    </div>

    <div class="mt-4">
        <div class="flex flex-row justify-between items-center mt-2 mb-6">
            <div class="flex gap-2 items-center text-gray-500">
                <x-icons.info size="30" />
                <div>
                    Rows marked with a blue left border are specific to <span class="font-bold">this audit</span>
                </div>
            </div>

            <div class="w-full flex justify-end gap-2">

            <x-jet-button wire:click="notifyAssignedUsers" class="flex items-center gap-1 bg-blue-500 hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                <div>Notify Assigned Users</div>
            </x-jet-button>
            {{-- Duplicate Audit Button --}}
            <x-jet-button wire:click="duplicateAudit" class="bg-gray-700 hover:bg-gray-800 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m0 4h2a2 2 0 012 2v8a2 2 0 01-2 2h-8a2 2 0 01-2-2v-2" />
                </svg>
                Duplicate Audit
            </x-jet-button>

            @php $canChangeClient = auth()->user()->hasAnyRole(['Administrator','Analyst','Jnr Analyst']); @endphp

            @if($canChangeClient)
            <button
                type="button"
                class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                wire:click="openChangeClientModal"
                style="font-size: 0.75rem;font-family:Inter; letter-spacing:1.2px; font-weight:600;"
            >
                CHANGE CLIENT
            </button>
            @endif


        {{-- Export Dropdown --}}
        <x-jet-dropdown>
            <x-slot name="trigger">
                <x-jet-button class="flex items-center gap-1">
                    <x-icons.table-export size="20" />
                    <div>Export</div>
                </x-jet-button>
            </x-slot>

                <x-slot name="content">
                    <x-jet-dropdown-link>
                        <div wire:click="export">
                            Download Excel
                        </div>
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link>
                        <div wire:click="emailExcel">
                            Email Excel
                        </div>
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link>
                        <div onclick="generatePdfReport('download')">Download PDF Summary</div>
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link>
                        <div wire:click="openEmailPdfModal">Email PDF Summary</div>
                    </x-jet-dropdown-link>
                </x-slot>
        </x-jet-dropdown>
        </div>

        </div>

        <div wire:loading.class="opacity-50" wire:target="searchString" class="space-y-4 transition-opacity">
        @foreach ($this->filteredData as $group)
        @if(count($group['folders']) > 0)
            <div class="bg-gray-200 p-4 mb-4 rounded"
                wire:key="group-{{ $audit->id }}-{{ md5($group['top_level']) }}">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-700 uppercase">
                        {{ $group['top_level'] }}
                    </h2>
                    <x-jet-button
                            type="button"
                            x-data
                            x-on:click="
                                const name = window.prompt('Folder name for {{ addslashes($group['top_level']) }}');
                                if (name) $wire.quickCreateFolder('{{ addslashes($group['top_level']) }}', name);
                            "
                        >New Folder</x-jet-button>
                </div>

                @foreach($group['folders'] as $folder)
                        @php
                        $folderChecksum = md5($folder->referenceItems->pluck('id')->join(','));
                        @endphp
                        <div
                            wire:key="folder-{{ $audit->id }}-{{ $folder->getKey() }}-{{ $folderChecksum }}"
                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                            class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2"
                        >
                            <table class="table-auto w-full text-sm text-left overflow-hidden text-gray-600 dark:text-gray-400 border-collapse rounded-lg">
                                <thead class="relative text-xs text-gray-800 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr id="folder-{{ $folder->id }}">
                                        <th class="bg-gray-600" scope="col" colspan="2"></th>

                                        <th scope="col" class="py-3 text-right bg-gray-600 text-white text-base" colspan="4">
                                            <div class="flex justify-center">
                                                <div>{{ $folder->name }}</div>
                                            </div>
                                        </th>

                                        <th scope="col" class="py-3 pr-3 text-right bg-gray-600 text-white text-base" colspan="2">
                                        @can('edit audits')
                                            <x-jet-button wire:click="setNewRefItem({{ $folder->id }})" class="bg-gray-100">
                                                <div class="flex flex-row space-x-1">
                                                    <x-icons.plus size="15" />
                                                    <div class="font-bold">Add Item</div>
                                                </div>
                                            </x-jet-button>

                                            {{-- 🔹 New Responsible User Dropdown --}}

                                                &nbsp;&nbsp;<select style="color:black !important;"
    x-data
    wire:ignore
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    @disabled(!$canAssignResponsible)
    x-init="$nextTick(() => {
        const $jq = window.jQuery || window.$;
        if (!$jq) return;
        const inst = $jq($el).select2({
            width: '100%',
            dropdownParent: $jq('body'),
            placeholder: 'Assign Responsible User'
        });

        inst.on('change', e => {
            const val = e.target.value;
            if (val === '') return;
            
            // Set BOTH flags to ensure navigation is allowed
            sessionStorage.setItem('skipLeaveOnce', '1');
            localStorage.removeItem('audit:{{ $audit->id }}:assignDirty');
            
            $wire.updateFolderResponsibleUser({{ $folder->id }}, val).then(() => {
                inst.val('').trigger('change.select2');
                localStorage.setItem('audit-folder-scroll', 'folder-{{ $folder->id }}');
                
                // Force reload without prompt
                window.location.replace(window.location.href.split('#')[0]);
            });
        });
    })"
>
    <option value="">Assign Responsible User</option>
    @foreach ($this->getUsersForAudit() as $user)
        <option value="{{ $user->id }}">
            {{ $user->name }}
            @if ($user->hasRole('Administrator')) (Admin)
            @elseif ($user->hasRole('Analyst')) (Analyst)
            @elseif ($user->hasRole('Jnr Analyst')) (Junior)
            @endif
        </option>
    @endforeach
</select>
                                            
                                        @else
                                            <x-jet-button class="opacity-0 cursor-default">button</x-jet-button>
                                        @endcan
                                    </th>
                                    </tr>
                                    
                                    <tr>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="py-3 px-6">Name</th>
                                        <th scope="col" class="py-3 px-6">Date Requested</th>
                                        <th scope="col" class="py-3 px-6">Due Date</th>
                                        <th scope="col" class="py-3 px-6">Responsible User</th>
                                        <th scope="col" class="py-3 px-6 text-center">Uploaded By</th>
                                        @can('view last checked')
                                            <th scope="col" class="py-3 px-6 text-center">Last Checked</th>
                                        @endcan
                                        <th scope="col" class="py-3 px-6 text-center" colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($folder->referenceItems) > 0)
                                    @foreach($folder->referenceItems as $ref)
                                    <tr 
                                        id="row-{{ $audit->id }}-{{ $ref->id }}"
                                        @if($ref->default == 0) style="box-shadow: inset 3px 0px 0px 0px #38BDF8;" @endif 
                                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 transition-opacity"
                                        wire:key="ref-{{ $audit->id }}-{{ $ref->getKey() }}"
                                        wire:loading.class="opacity-50"
                                        wire:target="setStatus({{ $ref->files->first() ? $ref->files->first()->id : '' }})"
                                        >
                                        {{-- Status --}}
                                        <td class="py-6 px-6 text-center">
                                        <div class="flex justify-center items-center">
                                            @php $file = $ref->files->first(); @endphp

                                            {{-- No file uploaded yet OR placeholder row (file_id is null) → show HOURGLASS --}}
                                            @if(!$file || $file->file_id === null)
                                            <div wire:key="status-button-{{ $ref->id }}">
                                                <div class="group relative">
                                                <div class="bg-amber-200 text-amber-900 max-w-max rounded-md">
                                                    <x-icons.hourglass />
                                                </div>
                                                <div class="pointer-events-none absolute top-full left-0 mt-2
         z-50 whitespace-nowrap rounded-md bg-amber-100 px-2 py-1
         text-sm font-bold text-amber-900 opacity-0 transition-opacity
         group-hover:opacity-100
         sm:left-1/2 sm:-translate-x-1/2">
                                                    Waiting for upload
                                                </div>
                                                </div>
                                            </div>

                                            {{-- File uploaded → show status (Pending/Accepted/Rejected). Pending only after upload --}}
                                            @else
                                            <div
                                                @can('edit audits')
                                                @if($canChangeStatus)
                                                    wire:click="setStatus({{ $file->id }})"
                                                    class="cursor-pointer"
                                                @else
                                                    class="cursor-default"
                                                @endif
                                                @endcan
                                                wire:key="status-button-{{ $ref->id }}"
                                            >
                                                @switch($file->status)
                                                @case(0) {{-- Pending (after upload, awaiting review) --}}
                                                    <div class="group relative">
                                                    <div class="bg-amber-200 text-amber-900 max-w-max rounded-md">
                                                        <x-icons.pending />
                                                    </div>
                                                    <div class="pointer-events-none absolute top-full left-0 mt-2
         z-50 whitespace-nowrap rounded-md bg-amber-100 px-2 py-1
         text-sm font-bold text-amber-900 opacity-0 transition-opacity
         group-hover:opacity-100
         sm:left-1/2 sm:-translate-x-1/2">
                                                        Pending review
                                                    </div>
                                                    </div>
                                                @break

                                                @case(1)
                                                    <div class="group relative">
                                                    <div class="bg-emerald-200 text-emerald-900 max-w-max rounded-md">
                                                        <x-icons.check />
                                                    </div>
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-emerald-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-emerald-900 font-bold z-50 shadow">
                                                        Accepted
                                                    </div>
                                                    </div>
                                                @break

                                                @case(2)
                                                    <div class="group relative">
                                                    <div class="bg-red-200 text-red-900 max-w-max rounded-md">
                                                        <x-icons.close />
                                                    </div>
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-red-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-red-900 font-bold z-50 shadow">
                                                        Rejected
                                                    </div>
                                                    </div>
                                                @break

                                                @default
                                                    <div class="group relative">
                                                    <div class="bg-amber-200 text-amber-900 max-w-max rounded-md">
                                                        <x-icons.hourglass />
                                                    </div>
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-amber-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-amber-900 font-bold z-50 shadow">
                                                        Waiting for upload
                                                    </div>
                                                    </div>
                                                @endswitch
                                            </div>
                                            @endif
                                        </div>
                                        </td>

                                        {{-- End status --}}

                                        {{-- Name --}}
                                        <td class="py-6 px-6" style="width: 100px;">
                                            <livewire:global-components.inline-edit 
                                                :model="'\\App\\Models\\AuditReference'"
                                                :entity="$ref"
                                                :field="'name'"
                                                :key="'audit-reference-asdasjhdkjsahd-'.$ref->id"
                                                permission='edit audits'
                                            />
                                        </td>
                                        {{-- End name --}}

                                        {{-- Date Requested --}}
                                        <td class="py-6 px-6" wire:key="requested-container-{{ $ref->id }}">
                                            @if($ref->files->first())
                                            <livewire:audit-management.components.inline-edit
                                                key="date-requested-{{ $ref->id }}"
                                                field="date_requested" 
                                                fileID="{{ $ref->files->first()->id }}" 
                                                type="date" 
                                                :file="$ref->files->first()" 
                                                permission='edit audits'
                                            />
                                            @else
                                            <div>
                                                <x-simple-inline-edit 
                                                    submit="setDate(Object.fromEntries(new FormData($event.target)), {{ $ref->id }})" 
                                                    name="date_requested"
                                                    permission='edit audits'
                                                />
                                            </div>
                                            @endif
                                        </td>
                                        {{-- End date requested --}}

                                        {{-- Due date --}}
                                        <td class="py-6 px-6" wire:key="due-date-container-{{ $ref->id }}">
                                            @if($ref->files->first())
                                            <livewire:audit-management.components.inline-edit
                                                key="due-date-{{ $ref->id }}"
                                                field="due_date" 
                                                fileID="{{ $ref->files->first()->id }}"
                                                type="date" 
                                                :file="$ref->files->first()" 
                                                permission='edit audits'
                                            />
                                            @else
                                            <div>
                                                <form 
                                                    x-data 
                                                    x-on:submit.prevent="confirmAndSetDate($event, {{ $ref->id }})"
                                                    class="flex gap-1"
                                                >
                                                    <input 
                                                        type="date" 
                                                        name="due_date"
                                                        class="border border-gray-300 rounded px-2 py-1"
                                                        required
                                                    >
                                                    
                                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                                                        Set
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </td>
                                        {{-- End due date --}}

                                        {{-- Responsible Person --}}
                                        <td class="py-6 px-6">
                                            @php $file = $ref->files->first(); @endphp

                                            @if(auth()->user()->hasRole('Client Sub User'))
                                                {{ optional(\App\Models\User::find(optional($file)->responsible_person_id))->name ?? 'Unassigned' }}
                                            @else
                                                @if($file)
                                                    <div
                                                        x-data="{
                                                            prev: '{{ (int)($file->responsible_person_id ?? 0) }}',
                                                            handle(e){
                                                                const val = e.target.value;
                                                                if (val === '__add_user') {
                                                                    // restore current selection
                                                                    e.target.value = this.prev || '';
                                                                    $wire.openAddUserModal('file', {{ (int) $file->id }});
                                                                } else {
                                                                    this.prev = val;
                                                                    if (val !== '') $wire.updateResponsiblePerson({{ (int) $file->id }}, val);
                                                                }
                                                            }
                                                        }"
                                                    >
                                                        <select
                                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                            @disabled(!$canAssignResponsible)
                                                            wire:ignore
                                                            x-data
                                                            x-init="$nextTick(() => {
                                                                const $jq = window.jQuery || window.$;
                                                                if (!$jq) return;
                                                                const inst = $jq($el).select2({
                                                                    width: '100%',
                                                                    dropdownParent: $jq('body'),
                                                                    placeholder: 'Select User'
                                                                });
                                                                inst.val(@js((string)($file->responsible_person_id ?? ''))).trigger('change.select2');
                                                                inst.on('change', e => handle(e));
                                                            })"
                                                        >
                                                            <option value="">Select User</option>

                                                            @foreach ($this->getUsersForAudit() as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ ((int)($file->responsible_person_id) === (int)$user->id) ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach

                                                            @if($canAssignResponsible)
                                                                <option value="__add_user">➕ Add new user…</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                @else
                                                    <span>Unassigned</span>
                                                @endif
                                            @endif
                                        </td>
                                        {{-- End Responsible Person --}}



                                        {{-- Date Uploaded --}}
                                        <td class="py-6 px-6 text-center" wire:key="created-at-container-{{ $ref->id }}">
                                        <div>
                                            @if ($ref->files->isNotEmpty() && $ref->files->first()->fileDetails && $ref->files->first()->fileDetails->user)
                                                @if(auth()->user()->hasAnyRole(['Client', 'Client Sub User']))
                                                    {{-- Display username as plain text --}}
                                                    <div>{{ $ref->files->first()->fileDetails->user->name }}</div>
                                                @else
                                                    {{-- Display username as clickable link --}}
                                                    <a href="../users/{{ $ref->files->first()->fileDetails->user->id }}" class="text-blue-600 hover:underline">
                                                        {{ $ref->files->first()->fileDetails->user->name }}
                                                    </a>
                                                @endif
                                            @else
                                                <span></span>
                                            @endif
                                        </div>
                                        <div>
                                            {{ $ref->files->first() ? $ref->files->first()->date_uploaded : '' }}
                                        </div>
                                    </td>
                                        {{-- End date uploaded --}}

                                        {{-- Date last checked --}}
                                        @can('view last checked')
                                            <td class="py-6 px-6 text-center" wire:key="last-checked-container-{{ $ref->id }}">
                                                <div>
                                                    @if ($ref->files->first() && $ref->files->first()->checked_by)
                                                        @if(auth()->user()->hasAnyRole(['Client', 'Client Sub User']))
                                                            {{-- Display username as plain text --}}
                                                            <div>{{ $ref->files->first()->checkedByUser->name }}</div>
                                                        @else
                                                            {{-- Display username as clickable link --}}
                                                            <a href="../users/{{ $ref->files->first()->checkedByUser->id }}" class="text-blue-600 hover:underline">
                                                                {{ $ref->files->first()->checkedByUser->name }}
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span></span>
                                                    @endif
                                                </div>
                                                <div>{{ $ref->files->first() ? $ref->files->first()->date_last_checked : '' }}</div>
                                            </td>
                                            @endcan
                                        {{-- End date last checked --}}

                                        {{-- Actions --}}
                                        <td class="py-6 px-6" colspan="2"> 
                                            @php
                                                $validFiles = $ref->files->filter(fn($f) => $f->fileDetails && $f->file_id !== null);
                                            @endphp

                                            @if($validFiles->count())
                                                <button
                                                    type="button"
                                                    wire:click="openFilesModal({{ $ref->id }})"
                                                    class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                                                    title="View all files for this item"
                                                >
                                                    View files ({{ $validFiles->count() }})
                                                </button>
                                                @if(false) @foreach($validFiles as $file)
                                                    <div class="space-y-2 mb-4">
                                                        <div class="flex flex-row gap-1 justify-center">
                                                            {{-- 💬 Comments --}}
                                                            <div wire:click="showFileComments({{ $file->id }})" class="relative group cursor-pointer hover:bg-purple-500 active:bg-purple-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <x-icons.comment />
                                                                @if($file->comments_count > 0)
                                                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                                                        {{ $file->comments_count }}
                                                                    </span>
                                                                @endif
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-purple-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-purple-900 font-bold">
                                                                    Comments
                                                                </div>
                                                            </div>

                                                            {{-- 📥 Download --}}
                                                            <div wire:click="download({{ $file->id }})" class="relative group cursor-pointer hover:bg-green-500 active:bg-green-600 hover:text-white p-1 rounded-md transition-colors"> 
                                                                <x-icons.download />
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-green-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-green-900 font-bold">
                                                                    Download
                                                                </div>
                                                            </div>

                                                            {{-- 👁️ View --}}
                                                            <a wire:click="setCheckedDate({{ $file->id }})" href="../file-viewer/{{ $file->fileDetails->id }}" target="_blank" class="relative group cursor-pointer hover:bg-blue-500 active:bg-blue-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <x-icons.eye />
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-blue-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-blue-900 font-bold">
                                                                    View
                                                                </div>
                                                            </a>

                                                            {{-- 🗑️ Delete --}}
                                                            @can('edit audits')
                                                            @if($canDelete)
                                                            <div wire:click="setRemoveFile({{ $file->fileDetails->id }})" class="relative group cursor-pointer hover:bg-red-500 active:bg-red-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <x-icons.bin />
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-red-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-red-900 font-bold">
                                                                    Delete File
                                                                </div>
                                                            </div>
                                                            @endif

                                                            {{-- 🔁 Replace --}}
                                                            <div wire:click="toggleReplaceFileModal({{ $file->id }})" class="relative group cursor-pointer hover:bg-amber-500 active:bg-amber-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <x-icons.refresh />
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-amber-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-amber-900 font-bold">
                                                                    Replace File
                                                                </div>
                                                            </div>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @endif

                                                <div 
                                                        class="mt-2 p-4 border-2 border-dashed border-gray-400 rounded-md text-center"
                                                        x-data="{ isDragging: false }"
                                                        x-on:dragover.prevent="isDragging = true"
                                                        x-on:dragleave="isDragging = false"
                                                        x-on:drop.prevent="
                                                            isDragging = false;
                                                            $refs.uploadInput.files = event.dataTransfer.files;
                                                            $wire.set('uploadingItemId', {{ $ref->id }});
                                                            $wire.uploadMultiple('uploadFiles', event.dataTransfer.files, () => $wire.inlineUpload());
                                                        "
                                                        :class="{ 'border-green-500 bg-green-100': isDragging }"
                                                    >
                                                        <input 
                                                            type="file" wire:model="uploadFiles"
                                                            x-ref="uploadInput" 
                                                            class="hidden" 
                                                            multiple
                                                            accept=".pdf,.jpg,.png,.doc,.docx,.xlsx"
                                                            x-on:change="
                                                                $wire.set('uploadingItemId', {{ $ref->id }});
                                                                $wire.uploadMultiple('uploadFiles', $refs.uploadInput.files, () => $wire.inlineUpload());
                                                            "
                                                        >
                                                        <p class="text-gray-600">
                                                            Drag & Drop files here or 
                                                            <button 
                                                                type="button" 
                                                                x-on:click="$refs.uploadInput.click()" 
                                                                class="text-blue-500 underline">
                                                                Browse
                                                            </button>
                                                        </p>

                                                        {{-- ✅ Upload Progress --}}
                                                        <div wire:loading wire:target="uploadFiles">
                                                            <p class="text-green-600">Uploading...</p>
                                                        </div>

                                                        {{-- ✅ Upload Errors --}}
                                                        @error('uploadFiles.*') 
                                                            <span class="text-red-500">{{ $message }}</span> 
                                                        @enderror
                                                    </div>

                                            @else {{-- No file uploaded --}}
                                                @can('edit audits')
                                                    @if($canDelete)
                                                    <div onclick="if (confirm('Are you sure you want to remove this reference from the audit?')) @this.removeReference({{ $ref->id }})"
                                                        class="relative group cursor-pointer hover:bg-red-500 active:bg-red-600 hover:text-white p-1 rounded-md transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-700" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 5a1 1 0 112 0v7a1 1 0 11-2 0V7zm-3 0a1 1 0 112 0v7a1 1 0 11-2 0V7zm6 0a1 1 0 112 0v7a1 1 0 11-2 0V7z" clip-rule="evenodd" />
                                                        </svg>
                                                        <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-red-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-red-900 font-bold">
                                                            Remove from Audit
                                                        </div>
                                                    </div>
                                                    @endif


                                                    <div 
                                                        class="mt-2 p-4 border-2 border-dashed border-gray-400 rounded-md text-center"
                                                        x-data="{ isDragging: false }"
                                                        x-on:dragover.prevent="isDragging = true"
                                                        x-on:dragleave="isDragging = false"
                                                        x-on:drop.prevent="
                                                            isDragging = false;
                                                            $refs.uploadInput.files = event.dataTransfer.files;
                                                            $wire.set('uploadingItemId', {{ $ref->id }});
                                                            $wire.uploadMultiple('uploadFiles', event.dataTransfer.files, () => $wire.inlineUpload());
                                                        "
                                                        :class="{ 'border-green-500 bg-green-100': isDragging }"
                                                    >
                                                        <input 
                                                            type="file" wire:model="uploadFiles"
                                                            x-ref="uploadInput" 
                                                            class="hidden" 
                                                            multiple
                                                            accept=".pdf,.jpg,.png,.doc,.docx,.xlsx"
                                                            x-on:change="
                                                                $wire.set('uploadingItemId', {{ $ref->id }});
                                                                $wire.uploadMultiple('uploadFiles', $refs.uploadInput.files, () => $wire.inlineUpload());
                                                            "
                                                        >
                                                        <p class="text-gray-600">
                                                            Drag & Drop files here or 
                                                            <button 
                                                                type="button" 
                                                                x-on:click="$refs.uploadInput.click()" 
                                                                class="text-blue-500 underline">
                                                                Browse
                                                            </button>
                                                        </p>

                                                        {{-- ✅ Upload Progress --}}
                                                        <div wire:loading wire:target="uploadFiles">
                                                            <p class="text-green-600">Uploading...</p>
                                                        </div>

                                                        {{-- ✅ Upload Errors --}}
                                                        @error('uploadFiles.*') 
                                                            <span class="text-red-500">{{ $message }}</span> 
                                                        @enderror
                                                    </div>

                                                @endcan
                                            @endif
                                        </td>
                                        {{-- End actions --}}
                                    </tr>
                                    @endforeach
                                @else
                                    {{-- No items in folder --}}
                                    <tr>
                                        <td colspan="9" class="py-6 text-gray-500">
                                            <div class="text-center">There are no items in this category, for this audit.</div>
                                            <div class="text-center">Click the New button above to add some.</div>
                                        </td>
                                    </tr>
                                    {{-- End no items in folder --}}
                                @endif
                                </tbody>
                            </table>
                        </div>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>

    {{-- MODALS --}}
    {{-- Files Modal (Jetstream) --}}
    <x-jet-dialog-modal wire:model="showFilesModal">
        <x-slot name="title">Files — {{ $modalRefTitle }}</x-slot>

        <x-slot name="content">
            <div class="max-h-[60vh] overflow-y-auto">
                @if(!empty($modalFiles))
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="py-2 px-2">File</th>
                                <th class="py-2 px-2">Uploaded By</th>
                                <th class="py-2 px-2">Uploaded</th>
                                <th class="py-2 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modalFiles as $mf)
                                <tr class="border-t">
                                    <td class="py-2 px-2">
                                        {{ $mf['file_details']['file_name'] ?? ($mf['fileDetails']['file_name'] ?? 'File') }}.{{ $mf['file_details']['type'] ?? ($mf['fileDetails']['type'] ?? '') }}
                                    </td>
                                    <td class="py-2 px-2">
                                        {{ $mf['file_details']['user']['name'] ?? ($mf['fileDetails']['user']['name'] ?? '') }}
                                    </td>
                                    <td class="py-2 px-2">
                                        {{ $mf['date_uploaded'] ?? '' }}
                                    </td>
                                    <td class="py-2 px-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <div wire:click="showFileComments({{ $mf['id'] ?? '' }})" class="relative group cursor-pointer hover:bg-purple-500 active:bg-purple-600 hover:text-white p-1 rounded-md transition-colors">
                                                <x-icons.comment />
                                                @php $cc = (int)($mf['comments_count'] ?? 0); @endphp
                                                @if($cc > 0)
                                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                                        {{ $cc }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div wire:click="download({{ $mf['id'] ?? '' }})" class="relative group cursor-pointer hover:bg-green-500 active:bg-green-600 hover:text-white p-1 rounded-md transition-colors">
                                                <x-icons.download />
                                            </div>
                                            @php $fdid = $mf['file_details']['id'] ?? ($mf['fileDetails']['id'] ?? null); @endphp
                                            <a @if(isset($mf['id'])) wire:click="setCheckedDate({{ $mf['id'] }})" @endif href="../file-viewer/{{ $fdid }}" target="_blank" class="relative group cursor-pointer hover:bg-blue-500 active:bg-blue-600 hover:text-white p-1 rounded-md transition-colors">
                                                <x-icons.eye />
                                            </a>
                                            @can('edit audits')
                                            <div wire:click="setRemoveFile({{ $fdid }})" class="relative group cursor-pointer hover:bg-red-500 active:bg-red-600 hover:text-white p-1 rounded-md transition-colors">
                                                <x-icons.bin />
                                            </div>
                                            <div @if(isset($mf['id'])) wire:click="toggleReplaceFileModal({{ $mf['id'] }})" @endif class="relative group cursor-pointer hover:bg-amber-500 active:bg-amber-600 hover:text-white p-1 rounded-md transition-colors">
                                                <x-icons.refresh />
                                            </div>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-gray-500 text-sm">No files found for this item.</div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeFilesModal" class="mr-2">Close</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- Email PDF Summary modal --}}
    <x-jet-dialog-modal wire:model="showEmailPdfModal">
        <x-slot name="title">Email PDF Summary</x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="email-to" value="To (comma-separated)" />
                    <x-jet-input id="email-to" type="text" class="w-full"
                        {{-- optional Livewire binding if you add the prop below --}}
                        wire:model.defer="emailPdf.to"
                        placeholder="name@example.com, other@example.com" />
                </div>

                <div>
                    <x-jet-label for="email-cc" value="CC (optional, comma-separated)" />
                    <x-jet-input id="email-cc" type="text" class="w-full"
                        wire:model.defer="emailPdf.cc"
                        placeholder="cc1@example.com, cc2@example.com" />
                </div>

                <p class="text-xs text-gray-500">
                    We’ll generate the PDF now and email it to the addresses above.
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex items-center gap-2">
                <x-buttons.cancel-button wire:click="$set('showEmailPdfModal', false)">Cancel</x-buttons.cancel-button>
                <x-jet-button
                    onclick="emailPdfSummary()"
                >Send PDF</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- End Email PDF Summary modal --}}


        {{-- Outlook email modal --}}
        <livewire:global-components.outlook-email :contactEmails="$contactEmails" />
        {{-- End Outlook email modal --}}

        {{-- Category modal --}}
        <x-jet-dialog-modal wire:model="showNewCategoryModal">
            <x-slot name="title">New Category</x-slot>

            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <x-jet-label for="top-level-name" value="Top-Level Category" />
                        <x-jet-input type="text" id="top-level-name" wire:model.defer="newCategory.top_level" class="w-full" />
                    </div>
                    <div>
                        <x-jet-label for="category-name" value="Folder Name" />
                        <x-jet-input type="text" id="category-name" wire:model.defer="newCategory.name" class="w-full" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end items-center space-x-1">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="createNewCategory">Create</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End Category modal --}}

        {{-- File upload modal --}}
        <x-jet-dialog-modal wire:model="showFileUploadModal">
            <x-slot name="title">Upload File</x-slot>

            <x-slot name="content">
                <div>
                    <x-input.filepond key="filepond-upload-{{ $currentReferenceID }}" wire:model="file" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end items-center space-x-1">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="upload">Upload</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End File upload modal --}}

        {{-- Replace file modal --}}
        <x-jet-dialog-modal wire:model="showReplaceFileUploadModal">
            <x-slot name="title">Replace File</x-slot>

            <x-slot name="content">
                <div>
                    <x-input.filepond key="filepond-upload-replace-{{ $currentReferenceID }}" wire:model="newFile" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end items-center space-x-1">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="replaceFile">Replace</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End Replace file modal --}}

        {{-- New reference item modal --}}
        <x-jet-dialog-modal wire:model="showNewRefItemModal">
            <x-slot name="title">Add Item</x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div class="w-full flex justify-center">
                        <x-tabs.tab-layout>
                            @foreach ($tabs as $tab)
                                <x-tabs.tab 
                                    :current="$currentTab === $tab ? true : false"
                                    click="$set('currentTab','{{ $tab }}')"
                                    >
                                    {{ ucfirst($tab) }}
                                </x-tabs.tab>
                            @endforeach
                        </x-tabs.tab-layout>
                    </div>

                    @if($currentTab === 'new item')
                    <div class="space-y-4">
                        <div>
                            <x-jet-label for="item-name" value="Name" />
                            <x-jet-input id="name" type="text" wire:model.defer="newRefItem.name" />
                        </div>

                        <div class="flex flex-row-reverse justify-end items-center gap-1">
                            <x-jet-label for="item-check" value="Add as default?" />
                            <x-jet-checkbox type="checkbox" id="item-check" wire:model="newRefItem.default" />
                        </div>
                    </div>
                    @endif

                    @if($currentTab === 'existing item')
                    <div class="space-y-2">
                        @forelse ($this->specificItems as $item)
                            <div class="flex gap-1 items-center">
                                <x-jet-checkbox type="checkbox" id="check-{{ $item->id }}" value="{{ $item->id }}" wire:model="addingItems" />
                                <x-jet-label for="check-{{ $item->id }}">{{ $item->name }}</x-jet-label>
                            </div>
                        @empty
                            <div class="py-6 text-gray-500 text-center">
                                All items from this folder have been added already
                            </div>
                        @endforelse
                    </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center gap-1">
                    <x-buttons.cancel-button wire:click="cancelAddItems">Cancel</x-buttons.cancel-button>
                    @if($currentTab === 'new item')
                    <x-jet-button wire:click="createRefItem">Create</x-jet-button>
                    @elseif($currentTab === 'existing item')
                    <x-jet-button wire:click="addExistingItems">Add Items</x-jet-button>
                    @endif
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End new reference item modal --}}

        {{-- Delete file modal --}}
        <x-jet-confirmation-modal wire:model="showConfirmDeleteFileModal">
            <x-slot name="title">Remove file</x-slot>

            <x-slot name="content">
                <div>Are you sure you would like to delete this file?</div>
                <div class="font-bold text-gray-500">This action is irreversible</div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-end gap-1">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="removeFile">Delete</x-jet-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
        {{-- End delete file modal --}}
        
        {{-- Comments Modal --}}
        <x-jet-dialog-modal wire:model="showCommentsModal">
            <x-slot name="title">Comments</x-slot>
            <x-slot name="content">
                {{-- <div class="space-y-4">
                    <div>
                        <x-jet-label for="internal-comments" value="Internal Comments" />
                        <div id="internal-comments">
                            <livewire:global-components.inline-edit
                                :model="'\\App\\Models\\AuditFile'"
                                :entity="$activeFile"
                                :field="'notes'"
                                :key="'notes-'.$activeFile->id"
                                lineID="notes-{{ $activeFile->id }}"
                                type="textarea"
                            />
                        </div>
                    </div>

                    <div>
                        <x-jet-label for="client-comments" value="Client Comments" />
                        <div id="client-comments">
                            <livewire:global-components.inline-edit
                                :model="'\\App\\Models\\AuditFile'"
                                :entity="$activeFile"
                                :field="'client_comments'"
                                :key="'client-comments-'.$activeFile->id"
                                lineID="audit-item-{{ $activeFile->id }}"
                                type="textarea"
                            />
                        </div>
                    </div>
                </div> --}}

                <livewire:global-components.comment-section 
                    :entity="$activeFile" 
                    :activityEntity="$audit" 
                    :activityData="['path' => 'Audits / ' . $audit->client()->withTrashed()->first()->name . ' / ' . $audit->name]" 
                />
            </x-slot>
            <x-slot name="footer">
                <x-jet-button x-on:click="show = false">Close</x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End comments Modal --}}

        {{-- Create & Assign User modal --}}
        <x-jet-dialog-modal wire:model="showAddUserModal">
            <x-slot name="title">Add new user & assign</x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <x-jet-label value="First name" />
                            <x-jet-input type="text" wire:model.defer="newUser.first_name" class="w-full" />
                            @error('newUser.first_name') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <x-jet-label value="Last name" />
                            <x-jet-input type="text" wire:model.defer="newUser.last_name" class="w-full" />
                            @error('newUser.last_name') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <x-jet-label value="Email" />
                        <x-jet-input type="email" wire:model.defer="newUser.email" class="w-full" />
                        @error('newUser.email') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <x-jet-label value="Role" />
                            <select class="mt-1 w-full rounded border-gray-300" wire:model.defer="newUser.role">
                                <option value="Analyst">Analyst</option>
                                <option value="Client">Client</option>
                                <option value="Client Sub User">Client Sub User</option>
                            </select>
                            @error('newUser.role') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <x-jet-label value="Phone (optional)" />
                            <x-jet-input type="text" wire:model.defer="newUser.phone" class="w-full" />
                            @error('newUser.phone') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="text-xs text-gray-500">
                        The new user will be created under the current client/company, enabled, and assigned immediately.
                        A password reset email will be sent so they can set their password.
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center gap-2">
                    <x-buttons.cancel-button wire:click="$set('showAddUserModal', false)">Cancel</x-buttons.cancel-button>
                    <x-jet-button wire:click="saveNewUserAndAssign">Save & Assign</x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
        {{-- End Create & Assign User modal --}}


        {{-- Confirm remove/delete ref --}}
        <x-jet-confirmation-modal wire:model="showConfirmRemoveRefModal">
            <x-slot name="title">{{ $deletingRef->default === 1 ? 'Remove' : 'Delete' }} Reference</x-slot>

            <x-slot name="content">
                <div>
                    Are you sure you would like to <span class="font-bold">{{ $deletingRef->default === 1 ? 'remove' : 'delete' }}</span> this reference item.
                    
                    @if ($deletingRef->default === 1)
                        <div class="text-gray-500 text-sm mt-2">
                            This will remove this reference item from this audit, however it can be re-added at a later stage.
                        </div>
                    @else
                        <div class="text-gray-500 text-sm mt-2">
                            This will <span class="font-bold">permanently delete</span> this reference item. This action is <span class="font-bold">irreversible.</span>
                        </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end items-center gap-1">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-buttons.delete-button wire:click="deleteReference">Delete</x-buttons.delete-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
        {{-- End confirm remove/delete ref --}}

        {{-- File replace error --}}
        <x-jet-confirmation-modal wire:model="showFileReplaceError">
            <x-slot name="title">Error</x-slot>
            <x-slot name="content">
                <div>
                    <div>File could not be replaced.</div>
                    <div>Please try deleting the file, and uploading the new one.</div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-button x-on:click="show = false">Close</x-button>
            </x-slot>
        </x-jet-confirmation-modal>
        {{-- End file replace error --}}
    {{-- END MODALS --}}

    {{-- Colours --}}
        <div class="hidden">
            <div class="bg-green-50"></div>
            <div class="bg-green-100"></div>
            <div class="bg-green-200"></div>

            <div class="bg-sky-50"></div>
            <div class="bg-sky-100"></div>
            <div class="bg-sky-200"></div>
        </div>
    {{-- End colours --}}

</div>

@if(request('tab') === 'edit-details')
    <div>
        @livewire('audit-management.edit-audit-details', ['auditId' => $audit->id], key('edit-audit-' . $audit->id))
    </div>
@endif

<script>
  // Create folder without opening a modal - prompts for folder name.
  window.quickCreateAuditFolder = function(topLevel) {
    try {
      var name = window.prompt('Folder name for "' + topLevel + '"');
      if (!name) return;
      
      // Find the AuditSection component (this component) by searching for the wire:id
      // within the audit-section root element
      const sectionRoot = document.querySelector('[wire\\:id][wire\\:initial-data*="AuditSection"]');
      const compId = sectionRoot ? sectionRoot.getAttribute('wire:id') : null;
      
      if (compId) {
        Livewire.find(compId)?.call('quickCreateFolder', topLevel, name);
      } else {
        // Fallback: emit event (though direct call is preferred)
        console.warn('Could not find AuditSection component, trying event emit');
        Livewire.emit('quickCreateFolder', topLevel, name);
      }
    } catch (e) {
      console.warn('quickCreateAuditFolder failed', e);
    }
  };
</script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const key = 'audit-folder-scroll';
    const targetId = localStorage.getItem(key);
    if (!targetId) return;
    localStorage.removeItem(key);
    requestAnimationFrame(() => {
      const el = document.getElementById(targetId);
      if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
</script>

{{-- Removed accidental AuditSection rename prompt; keep Audit Defaults owning this feature. --}}

@if($showChangeClientModal)
  <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60">
    <div class="relative bg-white rounded-xl shadow-2xl w-[90%] max-w-md p-6">
      <h3 class="text-lg font-bold mb-4 text-gray-800">Change Audit Client</h3>

      <div class="space-y-3">
        <label class="block text-sm font-medium text-gray-700">Select Client</label>
        <select
          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          wire:model="selectedClientId"
        >
          @foreach($this->allClients as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
          @endforeach
        </select>
        <p class="text-xs text-gray-500">
          Only the audit’s <code>client_id</code> will change. Linked files remain unchanged.
        </p>
      </div>

      <div class="mt-6 flex justify-end gap-2">
        <button
          type="button"
          class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50"
          wire:click="$set('showChangeClientModal', false)"
        >
          Cancel
        </button>

        <button
          type="button"
          class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50"
          wire:click="changeAuditClient"
          @disabled="!$wire.selectedClientId"
        >
          Update
        </button>
      </div>
    </div>
  </div>
@endif

<script>
    function confirmAndSetDate(event, refId) {
        
    }
</script>

<script>
    document.addEventListener('livewire:load', () => {
    let scrollTargetId = null;

    // Save target before the DOM updates
    window.addEventListener('remember-scroll', (e) => {
        scrollTargetId = e?.detail?.targetId || null;
    });

    // After Livewire has morphed the DOM, do the scroll
    Livewire.hook('message.processed', () => {
        if (!scrollTargetId) return;
        const el = document.getElementById(scrollTargetId);
        if (el) el.scrollIntoView({ block: 'start', behavior: 'smooth' });
        scrollTargetId = null;
    });
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
    async function generatePdfReport(action = "download", to = null, cc = null) {
        const LW_ID = @js($this->id);

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Fetch audit data from Livewire
        const response = await fetch("{{ route('get-audit-data', ['auditId' => $audit->id]) }}");
        const data = await response.json();

        const auditId = "{{ $audit->id }}";

        const { totalFiles, totalAccepted, totalPending, totalRejected, totalEmpty, pendingFiles, acceptedFiles, rejectedFiles, emptyFiles } = data;

        // Page settings
        const pageHeight = doc.internal.pageSize.height;
        const margin = 15;
        let yPos = 20;

        function checkPageBreak(yPos, extraSpace = 10) {
            if (yPos + extraSpace > pageHeight) {
                doc.addPage();
                return 20;
            }
            return yPos;
        }

        // Title
        doc.setFont("helvetica", "bold");
        doc.setFontSize(16);
        doc.text("Audit Summary Report", margin, yPos);
        yPos += 10;

        // Summary
        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);
        const summaryLines = [
            `Accepted: ${totalAccepted}`,
            `Pending: ${totalPending}`,
            `Rejected: ${totalRejected}`,
            `Still to be uploaded: ${totalEmpty - totalRejected}`
        ];
        summaryLines.forEach(line => {
            yPos = checkPageBreak(yPos, 10);
            doc.text(line, margin, yPos);
            yPos += 10;
        });

        // Sections
        function addSection(title, files, color) {
            if (!files.length) return;

            // Group files by section (prepend top level if you want)
            const bySection = files.reduce((acc, f) => {
                const tl = f.top_level ? `${f.top_level} / ` : "";
                const key = `${tl}${f.section || 'Uncategorized'}`;
                (acc[key] ||= []).push(f);
                return acc;
            }, {});

            // Section heading
            yPos = checkPageBreak(yPos, 15);
            doc.setTextColor(color);
            doc.setFontSize(14);
            doc.text(title, margin, yPos);
            yPos += 10;
            doc.setTextColor(0, 0, 0);
            doc.setFontSize(10);

            let counter = 1; // continuous numbering within this status block

            Object.keys(bySection).sort().forEach((sectionName) => {
                // Section name line
                yPos = checkPageBreak(yPos, 10);
                doc.setFont("helvetica", "bold");
                doc.text(sectionName, margin, yPos);
                yPos += 6;
                doc.setFont("helvetica", "normal");

                bySection[sectionName].forEach((file) => {
                const line = `${counter}. ${file.name || 'N/A'} - ${file.uploadedBy || ''} (${file.dateUploaded || 'N/A'})`;
                const wrapped = doc.splitTextToSize(line, 180);
                const height = wrapped.length * 6;

                yPos = checkPageBreak(yPos, height);
                doc.text(wrapped, margin, yPos);
                yPos += height;
                counter++;
                });

                yPos += 6; // space after each section
            });
        }


        addSection("Accepted Files", acceptedFiles, "green");
        addSection("Pending Files", pendingFiles, "orange");
        addSection("Rejected Files", rejectedFiles, "red");
        addSection("Files Not Yet Uploaded", emptyFiles, "black");

        const clientName = "{{ Str::slug($audit->client()->withTrashed()->first()->name) }}";
        const auditName  = "{{ Str::slug($audit->name) }}";
        const year       = "{{ optional($audit->planned_audit_date)->year ?? now()->year }}";
        const filename   = `${clientName}_Audit_${auditName}_FY${year}.pdf`;

        if (action === "download") {
            doc.save(filename);
            return;
        }

        // 🔹 EMAIL branch — now accepts custom recipients
        if (action === "download") {
            doc.save(filename);
            return;
        }

        if (action === "email") {
            const pdfBlob = doc.output("blob");
            const formData = new FormData();
            formData.append("pdf", pdfBlob, filename);
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("audit_id", "{{ $audit->id }}");
            if (to) formData.append("to", to);
            if (cc) formData.append("cc", cc);

            try {
                const res = await fetch("{{ route('send-audit-report', ['auditId' => $audit->id]) }}", {
                    method: "POST",
                    body: formData
                });
                const data = await res.json();

                if (!res.ok) {
                    alert(data.message || 'Failed to email PDF.');
                    return;
                }

                alert(data.message || 'PDF emailed successfully');

                // ✅ close this Livewire component’s modal reliably
                const comp = window.Livewire && Livewire.find(LW_ID);
                if (comp) {
                    comp.set('showEmailPdfModal', false);
                    comp.set('emailPdf.to', '');
                    comp.set('emailPdf.cc', '');
                }
            } catch (e) {
                console.error(e);
                alert('Network error while sending email.');
            }
        }
    }

    // 🔸 reads the modal fields and calls generatePdfReport('email', to, cc)
    function emailPdfSummary() {
        const to = (document.getElementById('email-to')?.value || '').trim();
        const cc = (document.getElementById('email-cc')?.value || '').trim();
        if (!to) {
            alert('Please enter at least one recipient.');
            return;
        }
        generatePdfReport('email', to, cc);

    }
</script>

<script>
    document.addEventListener('livewire:load', () => {
    let scrollTargetId = null;

    window.addEventListener('remember-scroll', (e) => {
        scrollTargetId = e?.detail?.targetId || null;
    });

    Livewire.hook('message.processed', () => {
        if (!scrollTargetId) return;
        const el = document.getElementById(scrollTargetId);
        if (el) el.scrollIntoView({ block: 'nearest', behavior: 'instant' });
        scrollTargetId = null;
    });
    });
</script>

<script>
    (function () {
    const KEY = 'audit-scroll-target';

    // On full load, if we stored a target, scroll to it (with a small offset for sticky headers)
    window.addEventListener('DOMContentLoaded', () => {
        const stored = sessionStorage.getItem(KEY);
        if (stored) {
        const el = document.getElementById(stored);
        if (el) {
            el.scrollIntoView({ block: 'center', behavior: 'instant' });
            // adjust for fixed header if needed:
            window.scrollBy(0, -80);
        }
        sessionStorage.removeItem(KEY);
        }
    });
    })();
</script>

<script>
(function () {
  const AUDIT_ID   = @json($audit->id);
  const DIRTY_KEY  = `audit:${AUDIT_ID}:assignDirty`;
  const SCROLL_KEY = 'audit-scroll-target';
  const SKIP_ONCE  = 'skipLeaveOnce';

  // ------- helpers -------
  const isDirty  = () => localStorage.getItem(DIRTY_KEY) === '1';
  const setDirty = (v) => v ? localStorage.setItem(DIRTY_KEY,'1') : localStorage.removeItem(DIRTY_KEY);

  // 1) Top-level GUARD: if skip flag is set, stop ANY beforeunload listeners downstream.
  // This fires first because of {capture:true}.
  function skipGuard(e){
    if (sessionStorage.getItem(SKIP_ONCE) === '1') {
      // Do NOT call preventDefault here (that would *cause* a prompt).
      // Just block other listeners.
      e.stopImmediatePropagation();
    }
  }
  window.addEventListener('beforeunload', skipGuard, { capture: true });

  // 2) Your real handler: warns only when dirty and no programmatic reload
  function dirtyBeforeUnload(e){
    if (!isDirty() || sessionStorage.getItem(SKIP_ONCE) === '1') return;
    e.preventDefault();
    e.returnValue = ''; // Standard Chrome behaviour (custom text ignored)
  }
  window.addEventListener('beforeunload', dirtyBeforeUnload);

  // Mark dirty when assignments change; clear when notified
  window.addEventListener('assignment-changed', (e) => {
    if (String(e.detail?.auditId) === String(AUDIT_ID)) setDirty(true);
  });
  window.addEventListener('assignment-notified', (e) => {
    if (String(e.detail?.auditId) === String(AUDIT_ID)) setDirty(false);
  });

  // 3) Server-triggered hard refresh → skip the prompt once, then reload
  window.addEventListener('hard-refresh-to', (e) => {
    const targetId = e?.detail?.targetId || null;
    if (targetId) sessionStorage.setItem(SCROLL_KEY, targetId);

    // Skip prompts for THIS navigation and remove our own handler
    sessionStorage.setItem(SKIP_ONCE, '1');
    window.removeEventListener('beforeunload', dirtyBeforeUnload);

    // Replace current page (preserves query params like ?tab=details)
    location.replace(location.href);
  });

  // Restore scroll after reload and clear the skip flag
  window.addEventListener('DOMContentLoaded', () => {
    const id = sessionStorage.getItem(SCROLL_KEY);
    if (id) {
      const el = document.getElementById(id);
      if (el) el.scrollIntoView({ block: 'center', behavior: 'instant' });
      sessionStorage.removeItem(SCROLL_KEY);
    }
    sessionStorage.removeItem(SKIP_ONCE);
  });

  // Optional: confirm on in-app links while dirty
  document.addEventListener('click', (ev) => {
    if (!isDirty()) return;
    const a = ev.target.closest('a[href]');
    if (!a || a.target === '_blank' || a.hasAttribute('data-no-prompt')) return;
    try {
      const url = new URL(a.href, location.href);
      if (url.origin !== location.origin) return;
    } catch(_) { return; }
    if (!confirm('You have assigned users but haven’t notified them yet. Leave this page without notifying?')) {
      ev.preventDefault();
      ev.stopPropagation();
    }
  }, true);
})();
</script>
<script>
    (function () {
        function tightenAssignDropdowns() {
            var root = document.querySelector('.audit-details-page');
            if (!root) return;

            var selects = root.querySelectorAll('select');
            selects.forEach(function (sel) {
                try {
                    var hasAssignOption = false;
                    for (var i = 0; i < sel.options.length; i++) {
                        var t = (sel.options[i].text || '').trim().toLowerCase();
                        if (t === 'assign responsible user') { hasAssignOption = true; break; }
                    }
                    if (!hasAssignOption) return;

                    sel.style.width = '220px';
                    sel.classList.remove('w-full');
                    if (window.jQuery && jQuery.fn && jQuery.fn.select2 && jQuery(sel).data('select2')) {
                        try { jQuery(sel).select2('destroy'); } catch (e) {}
                        jQuery(sel).select2({ width: 220, dropdownParent: jQuery('body') });
                        var c = jQuery(sel).next('.select2');
                        c.css('width', '220px');
                    }
                } catch (e) {}
            });
        }

        document.addEventListener('DOMContentLoaded', tightenAssignDropdowns);
        window.addEventListener('load', tightenAssignDropdowns);
        document.addEventListener('livewire:load', function(){
            tightenAssignDropdowns();
            if (window.Livewire && Livewire.hook) {
                Livewire.hook('message.processed', function () { setTimeout(tightenAssignDropdowns, 0); });
            }
        });
    })();
</script>
