<?php
    $canDelete = !auth()->user()->hasAnyRole(['Client','Client Sub User']);
    $canChangeStatus = !auth()->user()->hasAnyRole(['Client','Client Sub User']);
    $canAssignResponsible = !auth()->user()->hasRole('Client Sub User');
?>

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
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success-event','data' => []]); ?>
<?php $component->withName('toast.success-event'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="fixed z-50 top-20 right-5 space-y-4">
            <?php if(session()->has('message')): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success','data' => ['message' => ''.e(session('message')).'']]); ?>
<?php $component->withName('toast.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['message' => ''.e(session('message')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>

    <?php
        // Calculate the total number of files to be audited (uploaded + not uploaded yet)
        $totalFilesAndEmpty = $this->auditSummary['totalFiles'] + $this->auditSummary['totalEmpty'];

        // Define the percentages for each status, handling division by zero
        $acceptedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalAccepted'] / $totalFilesAndEmpty) * 100) : 0;
        $pendingPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalPending'] / $totalFilesAndEmpty) * 100) : 0;
        $rejectedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalRejected'] / $totalFilesAndEmpty) * 100) : 0;
        $emptyPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalEmpty'] / $totalFilesAndEmpty) * 100) : 0;
    ?>

    <?php
        // Calculate the total number of files to be audited (uploaded + not uploaded yet)
        $totalFilesAndEmpty = $this->auditSummary['totalFiles'] + $this->auditSummary['totalEmpty'];

        // Define the percentages for each status, handling division by zero
        $acceptedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalAccepted'] / $totalFilesAndEmpty) * 100) : 0;
        $pendingPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalPending'] / $totalFilesAndEmpty) * 100) : 0;
        $rejectedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalRejected'] / $totalFilesAndEmpty) * 100) : 0;
        $emptyPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalEmpty'] / $totalFilesAndEmpty) * 100) : 0;
    ?>

    <?php
        // Calculate the total number of files to be audited (uploaded + not uploaded yet)
        $totalFilesAndEmpty = $this->auditSummary['totalFiles'] + $this->auditSummary['totalEmpty'];

        // Define the percentages for each status, handling division by zero
        $acceptedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalAccepted'] / $totalFilesAndEmpty) * 100) : 0;
        $pendingPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalPending'] / $totalFilesAndEmpty) * 100) : 0;
        $rejectedPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalRejected'] / $totalFilesAndEmpty) * 100) : 0;
        $emptyPercent = ($totalFilesAndEmpty > 0) ? round(($this->auditSummary['totalEmpty'] / $totalFilesAndEmpty) * 100) : 0;
    ?>

    <div id="auditSummary" class="p-6 border bg-white rounded-lg shadow-lg text-lg">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-bold">Audit Summary</h2>
                <div class="flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'button','xData' => true,'xOn:click' => '$wire.set(\'showNewCategoryModal\', true)']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'button','x-data' => true,'x-on:click' => '$wire.set(\'showNewCategoryModal\', true)']); ?>Add Category <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            </div>

        <div class="mt-2 text-sm text-gray-700 flex flex-wrap items-center gap-x-3 gap-y-2">
            <div class="font-semibold">Total: <?php echo e($totalFilesAndEmpty); ?></div>
            <span class="text-gray-400">·</span>
            <div class="text-emerald-600 font-semibold">Accepted <?php echo e($acceptedPercent); ?>%</div>
            <span class="text-gray-400">·</span>
            <div class="font-semibold" style="color:orange">Pending <?php echo e($pendingPercent); ?>%</div>
            <span class="text-gray-400">·</span>
            <div class="text-red-600 font-semibold">Rejected <?php echo e($rejectedPercent); ?>%</div>
            <span class="text-gray-400">·</span>
            <div class="text-gray-600 font-semibold">Not Uploaded <?php echo e($emptyPercent); ?>%</div>
        </div>

        <?php if($totalFilesAndEmpty > 0): ?>
            <div class="flex h-4 w-full rounded-full overflow-hidden mt-2">
                
                <div
                    class="bg-green-500 flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: <?php echo e($acceptedPercent); ?>%;"
                >
                    <?php if($acceptedPercent > 5): ?> <?php echo e($acceptedPercent); ?>% <?php endif; ?>
                </div>

                
                <div
                    class="bg-yellow-500 min-w-[0.5rem] flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: <?php echo e($pendingPercent); ?>%;  background-color:orange !important;"
                >
                    <?php if($pendingPercent > 5): ?> <?php echo e($pendingPercent); ?>% <?php endif; ?>
                </div>

                
                <div
                    class="bg-red-500 flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: <?php echo e($rejectedPercent); ?>%;"
                >
                    <?php if($rejectedPercent > 5): ?> <?php echo e($rejectedPercent); ?>% <?php endif; ?>
                </div>

                
                <div
                    class="bg-gray-400 flex items-center justify-end pr-2 font-bold text-white text-sm"
                    style="width: <?php echo e($emptyPercent); ?>%;"
                >
                    <?php if($emptyPercent > 5): ?> <?php echo e($emptyPercent); ?>% <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-gray-500 text-center py-4 mt-4">
                No files to audit.
            </div>
        <?php endif; ?>
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
                    inst.val(<?php echo \Illuminate\Support\Js::from($filterUser ?? '')->toHtml() ?>).trigger('change.select2');
                    inst.on('change', e => $wire.set('filterUser', e.target.value));
                })"
            >
                <option value="">All Users</option>
                <?php $__currentLoopData = $this->getUsersWithAssignedFilesForThisAuditProperty(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    inst.val(<?php echo \Illuminate\Support\Js::from($filterStatus ?? '')->toHtml() ?>).trigger('change.select2');
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
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.info','data' => ['size' => '30']]); ?>
<?php $component->withName('icons.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '30']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div>
                    Rows marked with a blue left border are specific to <span class="font-bold">this audit</span>
                </div>
            </div>

            <div class="w-full flex justify-end gap-2">

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'notifyAssignedUsers','class' => 'flex items-center gap-1 bg-blue-500 hover:bg-blue-600']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'notifyAssignedUsers','class' => 'flex items-center gap-1 bg-blue-500 hover:bg-blue-600']); ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                <div>Notify Assigned Users</div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'duplicateAudit','class' => 'bg-gray-700 hover:bg-gray-800 flex items-center gap-1']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'duplicateAudit','class' => 'bg-gray-700 hover:bg-gray-800 flex items-center gap-1']); ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m0 4h2a2 2 0 012 2v8a2 2 0 01-2 2h-8a2 2 0 01-2-2v-2" />
                </svg>
                Duplicate Audit
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php $canChangeClient = auth()->user()->hasAnyRole(['Administrator','Analyst','Jnr Analyst']); ?>

            <?php if($canChangeClient): ?>
            <button
                type="button"
                class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                wire:click="openChangeClientModal"
                style="font-size: 0.75rem;font-family:Inter; letter-spacing:1.2px; font-weight:600;"
            >
                CHANGE CLIENT
            </button>
            <?php endif; ?>


        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown','data' => []]); ?>
<?php $component->withName('jet-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
             <?php $__env->slot('trigger', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['class' => 'flex items-center gap-1']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'flex items-center gap-1']); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.table-export','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.table-export'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <div>Export</div>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
             <?php $__env->endSlot(); ?>

                 <?php $__env->slot('content', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => []]); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <div wire:click="export">
                            Download Excel
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => []]); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <div wire:click="emailExcel">
                            Email Excel
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => []]); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <div onclick="generatePdfReport('download')">Download PDF Summary</div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => []]); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <div wire:click="openEmailPdfModal">Email PDF Summary</div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>

        </div>

        <div wire:loading.class="opacity-50" wire:target="searchString" class="space-y-4 transition-opacity">
        <?php $__currentLoopData = $this->filteredData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(count($group['folders']) > 0): ?>
            <div class="bg-gray-200 p-4 mb-4 rounded"
                wire:key="group-<?php echo e($audit->id); ?>-<?php echo e(md5($group['top_level'])); ?>">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-700 uppercase">
                        <?php echo e($group['top_level']); ?>

                    </h2>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['type' => 'button','xData' => true,'xOn:click' => '
                                const name = window.prompt(\'Folder name for '.e(addslashes($group['top_level'])).'\');
                                if (name) $wire.quickCreateFolder(\''.e(addslashes($group['top_level'])).'\', name);
                            ']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'button','x-data' => true,'x-on:click' => '
                                const name = window.prompt(\'Folder name for '.e(addslashes($group['top_level'])).'\');
                                if (name) $wire.quickCreateFolder(\''.e(addslashes($group['top_level'])).'\', name);
                            ']); ?>New Folder <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>

                <?php $__currentLoopData = $group['folders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $folder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $folderChecksum = md5($folder->referenceItems->pluck('id')->join(','));
                        ?>
                        <div
                            wire:key="folder-<?php echo e($audit->id); ?>-<?php echo e($folder->getKey()); ?>-<?php echo e($folderChecksum); ?>"
                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                            class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2"
                        >
                            <table class="table-auto w-full text-sm text-left overflow-hidden text-gray-600 dark:text-gray-400 border-collapse rounded-lg">
                                <thead class="relative text-xs text-gray-800 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr id="folder-<?php echo e($folder->id); ?>">
                                        <th class="bg-gray-600" scope="col" colspan="2"></th>

                                        <th scope="col" class="py-3 text-right bg-gray-600 text-white text-base" colspan="4">
                                            <div class="flex justify-center">
                                                <div><?php echo e($folder->name); ?></div>
                                            </div>
                                        </th>

                                        <th scope="col" class="py-3 pr-3 text-right bg-gray-600 text-white text-base" colspan="2">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit audits')): ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'setNewRefItem('.e($folder->id).')','class' => 'bg-gray-100']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'setNewRefItem('.e($folder->id).')','class' => 'bg-gray-100']); ?>
                                                <div class="flex flex-row space-x-1">
                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.plus','data' => ['size' => '15']]); ?>
<?php $component->withName('icons.plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '15']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    <div class="font-bold">Add Item</div>
                                                </div>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                            

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
            localStorage.removeItem('audit:<?php echo e($audit->id); ?>:assignDirty');
            
            $wire.updateFolderResponsibleUser(<?php echo e($folder->id); ?>, val).then(() => {
                inst.val('').trigger('change.select2');
                localStorage.setItem('audit-folder-scroll', 'folder-<?php echo e($folder->id); ?>');
                
                // Force reload without prompt
                window.location.replace(window.location.href.split('#')[0]);
            });
        });
    })"
>
    <option value="">Assign Responsible User</option>
    <?php $__currentLoopData = $this->getUsersForAudit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($user->id); ?>">
            <?php echo e($user->name); ?>

            <?php if($user->hasRole('Administrator')): ?> (Admin)
            <?php elseif($user->hasRole('Analyst')): ?> (Analyst)
            <?php elseif($user->hasRole('Jnr Analyst')): ?> (Junior)
            <?php endif; ?>
        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
                                            
                                        <?php else: ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['class' => 'opacity-0 cursor-default']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'opacity-0 cursor-default']); ?>button <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php endif; ?>
                                    </th>
                                    </tr>
                                    
                                    <tr>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="py-3 px-6">Name</th>
                                        <th scope="col" class="py-3 px-6">Date Requested</th>
                                        <th scope="col" class="py-3 px-6">Due Date</th>
                                        <th scope="col" class="py-3 px-6">Responsible User</th>
                                        <th scope="col" class="py-3 px-6 text-center">Uploaded By</th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view last checked')): ?>
                                            <th scope="col" class="py-3 px-6 text-center">Last Checked</th>
                                        <?php endif; ?>
                                        <th scope="col" class="py-3 px-6 text-center" colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($folder->referenceItems) > 0): ?>
                                    <?php $__currentLoopData = $folder->referenceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr 
                                        id="row-<?php echo e($audit->id); ?>-<?php echo e($ref->id); ?>"
                                        <?php if($ref->default == 0): ?> style="box-shadow: inset 3px 0px 0px 0px #38BDF8;" <?php endif; ?> 
                                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 transition-opacity"
                                        wire:key="ref-<?php echo e($audit->id); ?>-<?php echo e($ref->getKey()); ?>"
                                        wire:loading.class="opacity-50"
                                        wire:target="setStatus(<?php echo e($ref->files->first() ? $ref->files->first()->id : ''); ?>)"
                                        >
                                        
                                        <td class="py-6 px-6 text-center">
                                        <div class="flex justify-center items-center">
                                            <?php $file = $ref->files->first(); ?>

                                            
                                            <?php if(!$file || $file->file_id === null): ?>
                                            <div wire:key="status-button-<?php echo e($ref->id); ?>">
                                                <div class="group relative">
                                                <div class="bg-amber-200 text-amber-900 max-w-max rounded-md">
                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.hourglass','data' => []]); ?>
<?php $component->withName('icons.hourglass'); ?>
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
                                                <div class="pointer-events-none absolute top-full left-0 mt-2
         z-50 whitespace-nowrap rounded-md bg-amber-100 px-2 py-1
         text-sm font-bold text-amber-900 opacity-0 transition-opacity
         group-hover:opacity-100
         sm:left-1/2 sm:-translate-x-1/2">
                                                    Waiting for upload
                                                </div>
                                                </div>
                                            </div>

                                            
                                            <?php else: ?>
                                            <div
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit audits')): ?>
                                                <?php if($canChangeStatus): ?>
                                                    wire:click="setStatus(<?php echo e($file->id); ?>)"
                                                    class="cursor-pointer"
                                                <?php else: ?>
                                                    class="cursor-default"
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                wire:key="status-button-<?php echo e($ref->id); ?>"
                                            >
                                                <?php switch($file->status):
                                                case (0): ?> 
                                                    <div class="group relative">
                                                    <div class="bg-amber-200 text-amber-900 max-w-max rounded-md">
                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.pending','data' => []]); ?>
<?php $component->withName('icons.pending'); ?>
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
                                                    <div class="pointer-events-none absolute top-full left-0 mt-2
         z-50 whitespace-nowrap rounded-md bg-amber-100 px-2 py-1
         text-sm font-bold text-amber-900 opacity-0 transition-opacity
         group-hover:opacity-100
         sm:left-1/2 sm:-translate-x-1/2">
                                                        Pending review
                                                    </div>
                                                    </div>
                                                <?php break; ?>

                                                <?php case (1): ?>
                                                    <div class="group relative">
                                                    <div class="bg-emerald-200 text-emerald-900 max-w-max rounded-md">
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
                                                    </div>
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-emerald-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-emerald-900 font-bold z-50 shadow">
                                                        Accepted
                                                    </div>
                                                    </div>
                                                <?php break; ?>

                                                <?php case (2): ?>
                                                    <div class="group relative">
                                                    <div class="bg-red-200 text-red-900 max-w-max rounded-md">
                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.close','data' => []]); ?>
<?php $component->withName('icons.close'); ?>
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
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-red-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-red-900 font-bold z-50 shadow">
                                                        Rejected
                                                    </div>
                                                    </div>
                                                <?php break; ?>

                                                <?php default: ?>
                                                    <div class="group relative">
                                                    <div class="bg-amber-200 text-amber-900 max-w-max rounded-md">
                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.hourglass','data' => []]); ?>
<?php $component->withName('icons.hourglass'); ?>
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
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-amber-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-amber-900 font-bold z-50 shadow">
                                                        Waiting for upload
                                                    </div>
                                                    </div>
                                                <?php endswitch; ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        </td>

                                        

                                        
                                        <td class="py-6 px-6" style="width: 100px;">
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.inline-edit', ['model' => '\\App\\Models\\AuditReference','entity' => $ref,'field' => 'name','permission' => 'edit audits'])->html();
} elseif ($_instance->childHasBeenRendered('audit-reference-asdasjhdkjsahd-'.$ref->id)) {
    $componentId = $_instance->getRenderedChildComponentId('audit-reference-asdasjhdkjsahd-'.$ref->id);
    $componentTag = $_instance->getRenderedChildComponentTagName('audit-reference-asdasjhdkjsahd-'.$ref->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('audit-reference-asdasjhdkjsahd-'.$ref->id);
} else {
    $response = \Livewire\Livewire::mount('global-components.inline-edit', ['model' => '\\App\\Models\\AuditReference','entity' => $ref,'field' => 'name','permission' => 'edit audits']);
    $html = $response->html();
    $_instance->logRenderedChild('audit-reference-asdasjhdkjsahd-'.$ref->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        </td>
                                        

                                        
                                        <td class="py-6 px-6" wire:key="requested-container-<?php echo e($ref->id); ?>">
                                            <?php if($ref->files->first()): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.components.inline-edit', ['field' => 'date_requested','fileID' => ''.e($ref->files->first()->id).'','type' => 'date','file' => $ref->files->first(),'permission' => 'edit audits'])->html();
} elseif ($_instance->childHasBeenRendered('date-requested-'.e($ref->id).'')) {
    $componentId = $_instance->getRenderedChildComponentId('date-requested-'.e($ref->id).'');
    $componentTag = $_instance->getRenderedChildComponentTagName('date-requested-'.e($ref->id).'');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('date-requested-'.e($ref->id).'');
} else {
    $response = \Livewire\Livewire::mount('audit-management.components.inline-edit', ['field' => 'date_requested','fileID' => ''.e($ref->files->first()->id).'','type' => 'date','file' => $ref->files->first(),'permission' => 'edit audits']);
    $html = $response->html();
    $_instance->logRenderedChild('date-requested-'.e($ref->id).'', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            <?php else: ?>
                                            <div>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.simple-inline-edit','data' => ['submit' => 'setDate(Object.fromEntries(new FormData($event.target)), '.e($ref->id).')','name' => 'date_requested','permission' => 'edit audits']]); ?>
<?php $component->withName('simple-inline-edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['submit' => 'setDate(Object.fromEntries(new FormData($event.target)), '.e($ref->id).')','name' => 'date_requested','permission' => 'edit audits']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        

                                        
                                        <td class="py-6 px-6" wire:key="due-date-container-<?php echo e($ref->id); ?>">
                                            <?php if($ref->files->first()): ?>
                                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.components.inline-edit', ['field' => 'due_date','fileID' => ''.e($ref->files->first()->id).'','type' => 'date','file' => $ref->files->first(),'permission' => 'edit audits'])->html();
} elseif ($_instance->childHasBeenRendered('due-date-'.e($ref->id).'')) {
    $componentId = $_instance->getRenderedChildComponentId('due-date-'.e($ref->id).'');
    $componentTag = $_instance->getRenderedChildComponentTagName('due-date-'.e($ref->id).'');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('due-date-'.e($ref->id).'');
} else {
    $response = \Livewire\Livewire::mount('audit-management.components.inline-edit', ['field' => 'due_date','fileID' => ''.e($ref->files->first()->id).'','type' => 'date','file' => $ref->files->first(),'permission' => 'edit audits']);
    $html = $response->html();
    $_instance->logRenderedChild('due-date-'.e($ref->id).'', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            <?php else: ?>
                                            <div>
                                                <form 
                                                    x-data 
                                                    x-on:submit.prevent="confirmAndSetDate($event, <?php echo e($ref->id); ?>)"
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
                                            <?php endif; ?>
                                        </td>
                                        

                                        
                                        <td class="py-6 px-6">
                                            <?php $file = $ref->files->first(); ?>

                                            <?php if(auth()->user()->hasRole('Client Sub User')): ?>
                                                <?php echo e(optional(\App\Models\User::find(optional($file)->responsible_person_id))->name ?? 'Unassigned'); ?>

                                            <?php else: ?>
                                                <?php if($file): ?>
                                                    <div
                                                        x-data="{
                                                            prev: '<?php echo e((int)($file->responsible_person_id ?? 0)); ?>',
                                                            handle(e){
                                                                const val = e.target.value;
                                                                if (val === '__add_user') {
                                                                    // restore current selection
                                                                    e.target.value = this.prev || '';
                                                                    $wire.openAddUserModal('file', <?php echo e((int) $file->id); ?>);
                                                                } else {
                                                                    this.prev = val;
                                                                    if (val !== '') $wire.updateResponsiblePerson(<?php echo e((int) $file->id); ?>, val);
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
                                                                inst.val(<?php echo \Illuminate\Support\Js::from((string)($file->responsible_person_id ?? ''))->toHtml() ?>).trigger('change.select2');
                                                                inst.on('change', e => handle(e));
                                                            })"
                                                        >
                                                            <option value="">Select User</option>

                                                            <?php $__currentLoopData = $this->getUsersForAudit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($user->id); ?>"
                                                                    <?php echo e(((int)($file->responsible_person_id) === (int)$user->id) ? 'selected' : ''); ?>>
                                                                    <?php echo e($user->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <?php if($canAssignResponsible): ?>
                                                                <option value="__add_user">➕ Add new user…</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                <?php else: ?>
                                                    <span>Unassigned</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        



                                        
                                        <td class="py-6 px-6 text-center" wire:key="created-at-container-<?php echo e($ref->id); ?>">
                                        <div>
                                            <?php if($ref->files->isNotEmpty() && $ref->files->first()->fileDetails && $ref->files->first()->fileDetails->user): ?>
                                                <?php if(auth()->user()->hasAnyRole(['Client', 'Client Sub User'])): ?>
                                                    
                                                    <div><?php echo e($ref->files->first()->fileDetails->user->name); ?></div>
                                                <?php else: ?>
                                                    
                                                    <a href="../users/<?php echo e($ref->files->first()->fileDetails->user->id); ?>" class="text-blue-600 hover:underline">
                                                        <?php echo e($ref->files->first()->fileDetails->user->name); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span></span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php echo e($ref->files->first() ? $ref->files->first()->date_uploaded : ''); ?>

                                        </div>
                                    </td>
                                        

                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view last checked')): ?>
                                            <td class="py-6 px-6 text-center" wire:key="last-checked-container-<?php echo e($ref->id); ?>">
                                                <div>
                                                    <?php if($ref->files->first() && $ref->files->first()->checked_by): ?>
                                                        <?php if(auth()->user()->hasAnyRole(['Client', 'Client Sub User'])): ?>
                                                            
                                                            <div><?php echo e($ref->files->first()->checkedByUser->name); ?></div>
                                                        <?php else: ?>
                                                            
                                                            <a href="../users/<?php echo e($ref->files->first()->checkedByUser->id); ?>" class="text-blue-600 hover:underline">
                                                                <?php echo e($ref->files->first()->checkedByUser->name); ?>

                                                            </a>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div><?php echo e($ref->files->first() ? $ref->files->first()->date_last_checked : ''); ?></div>
                                            </td>
                                            <?php endif; ?>
                                        

                                        
                                        <td class="py-6 px-6" colspan="2"> 
                                            <?php
                                                $validFiles = $ref->files->filter(fn($f) => $f->fileDetails && $f->file_id !== null);
                                            ?>

                                            <?php if($validFiles->count()): ?>
                                                <button
                                                    type="button"
                                                    wire:click="openFilesModal(<?php echo e($ref->id); ?>)"
                                                    class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                                                    title="View all files for this item"
                                                >
                                                    View files (<?php echo e($validFiles->count()); ?>)
                                                </button>
                                                <?php if(false): ?> <?php $__currentLoopData = $validFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="space-y-2 mb-4">
                                                        <div class="flex flex-row gap-1 justify-center">
                                                            
                                                            <div wire:click="showFileComments(<?php echo e($file->id); ?>)" class="relative group cursor-pointer hover:bg-purple-500 active:bg-purple-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.comment','data' => []]); ?>
<?php $component->withName('icons.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                <?php if($file->comments_count > 0): ?>
                                                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                                                        <?php echo e($file->comments_count); ?>

                                                                    </span>
                                                                <?php endif; ?>
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-purple-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-purple-900 font-bold">
                                                                    Comments
                                                                </div>
                                                            </div>

                                                            
                                                            <div wire:click="download(<?php echo e($file->id); ?>)" class="relative group cursor-pointer hover:bg-green-500 active:bg-green-600 hover:text-white p-1 rounded-md transition-colors"> 
                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.download','data' => []]); ?>
<?php $component->withName('icons.download'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-green-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-green-900 font-bold">
                                                                    Download
                                                                </div>
                                                            </div>

                                                            
                                                            <a wire:click="setCheckedDate(<?php echo e($file->id); ?>)" href="../file-viewer/<?php echo e($file->fileDetails->id); ?>" target="_blank" class="relative group cursor-pointer hover:bg-blue-500 active:bg-blue-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.eye','data' => []]); ?>
<?php $component->withName('icons.eye'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-blue-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-blue-900 font-bold">
                                                                    View
                                                                </div>
                                                            </a>

                                                            
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit audits')): ?>
                                                            <?php if($canDelete): ?>
                                                            <div wire:click="setRemoveFile(<?php echo e($file->fileDetails->id); ?>)" class="relative group cursor-pointer hover:bg-red-500 active:bg-red-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.bin','data' => []]); ?>
<?php $component->withName('icons.bin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-red-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-red-900 font-bold">
                                                                    Delete File
                                                                </div>
                                                            </div>
                                                            <?php endif; ?>

                                                            
                                                            <div wire:click="toggleReplaceFileModal(<?php echo e($file->id); ?>)" class="relative group cursor-pointer hover:bg-amber-500 active:bg-amber-600 hover:text-white p-1 rounded-md transition-colors">
                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.refresh','data' => []]); ?>
<?php $component->withName('icons.refresh'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                                <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-amber-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-amber-900 font-bold">
                                                                    Replace File
                                                                </div>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                                <div 
                                                        class="mt-2 p-4 border-2 border-dashed border-gray-400 rounded-md text-center"
                                                        x-data="{ isDragging: false }"
                                                        x-on:dragover.prevent="isDragging = true"
                                                        x-on:dragleave="isDragging = false"
                                                        x-on:drop.prevent="
                                                            isDragging = false;
                                                            $refs.uploadInput.files = event.dataTransfer.files;
                                                            $wire.set('uploadingItemId', <?php echo e($ref->id); ?>);
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
                                                                $wire.set('uploadingItemId', <?php echo e($ref->id); ?>);
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

                                                        
                                                        <div wire:loading wire:target="uploadFiles">
                                                            <p class="text-green-600">Uploading...</p>
                                                        </div>

                                                        
                                                        <?php $__errorArgs = ['uploadFiles.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                            <span class="text-red-500"><?php echo e($message); ?></span> 
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>

                                            <?php else: ?> 
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit audits')): ?>
                                                    <?php if($canDelete): ?>
                                                    <div onclick="if (confirm('Are you sure you want to remove this reference from the audit?')) window.livewire.find('<?php echo e($_instance->id); ?>').removeReference(<?php echo e($ref->id); ?>)"
                                                        class="relative group cursor-pointer hover:bg-red-500 active:bg-red-600 hover:text-white p-1 rounded-md transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-700" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 5a1 1 0 112 0v7a1 1 0 11-2 0V7zm-3 0a1 1 0 112 0v7a1 1 0 11-2 0V7zm6 0a1 1 0 112 0v7a1 1 0 11-2 0V7z" clip-rule="evenodd" />
                                                        </svg>
                                                        <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-red-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-red-900 font-bold">
                                                            Remove from Audit
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>


                                                    <div 
                                                        class="mt-2 p-4 border-2 border-dashed border-gray-400 rounded-md text-center"
                                                        x-data="{ isDragging: false }"
                                                        x-on:dragover.prevent="isDragging = true"
                                                        x-on:dragleave="isDragging = false"
                                                        x-on:drop.prevent="
                                                            isDragging = false;
                                                            $refs.uploadInput.files = event.dataTransfer.files;
                                                            $wire.set('uploadingItemId', <?php echo e($ref->id); ?>);
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
                                                                $wire.set('uploadingItemId', <?php echo e($ref->id); ?>);
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

                                                        
                                                        <div wire:loading wire:target="uploadFiles">
                                                            <p class="text-green-600">Uploading...</p>
                                                        </div>

                                                        
                                                        <?php $__errorArgs = ['uploadFiles.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                            <span class="text-red-500"><?php echo e($message); ?></span> 
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    
                                    <tr>
                                        <td colspan="9" class="py-6 text-gray-500">
                                            <div class="text-center">There are no items in this category, for this audit.</div>
                                            <div class="text-center">Click the New button above to add some.</div>
                                        </td>
                                    </tr>
                                    
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showFilesModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showFilesModal']); ?>
         <?php $__env->slot('title', null, []); ?> Files — <?php echo e($modalRefTitle); ?> <?php $__env->endSlot(); ?>

         <?php $__env->slot('content', null, []); ?> 
            <div class="max-h-[60vh] overflow-y-auto">
                <?php if(!empty($modalFiles)): ?>
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
                            <?php $__currentLoopData = $modalFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t">
                                    <td class="py-2 px-2">
                                        <?php echo e($mf['file_details']['file_name'] ?? ($mf['fileDetails']['file_name'] ?? 'File')); ?>.<?php echo e($mf['file_details']['type'] ?? ($mf['fileDetails']['type'] ?? '')); ?>

                                    </td>
                                    <td class="py-2 px-2">
                                        <?php echo e($mf['file_details']['user']['name'] ?? ($mf['fileDetails']['user']['name'] ?? '')); ?>

                                    </td>
                                    <td class="py-2 px-2">
                                        <?php echo e($mf['date_uploaded'] ?? ''); ?>

                                    </td>
                                    <td class="py-2 px-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <div wire:click="showFileComments(<?php echo e($mf['id'] ?? ''); ?>)" class="relative group cursor-pointer hover:bg-purple-500 active:bg-purple-600 hover:text-white p-1 rounded-md transition-colors">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.comment','data' => []]); ?>
<?php $component->withName('icons.comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                <?php $cc = (int)($mf['comments_count'] ?? 0); ?>
                                                <?php if($cc > 0): ?>
                                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                                        <?php echo e($cc); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div wire:click="download(<?php echo e($mf['id'] ?? ''); ?>)" class="relative group cursor-pointer hover:bg-green-500 active:bg-green-600 hover:text-white p-1 rounded-md transition-colors">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.download','data' => []]); ?>
<?php $component->withName('icons.download'); ?>
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
                                            <?php $fdid = $mf['file_details']['id'] ?? ($mf['fileDetails']['id'] ?? null); ?>
                                            <a <?php if(isset($mf['id'])): ?> wire:click="setCheckedDate(<?php echo e($mf['id']); ?>)" <?php endif; ?> href="../file-viewer/<?php echo e($fdid); ?>" target="_blank" class="relative group cursor-pointer hover:bg-blue-500 active:bg-blue-600 hover:text-white p-1 rounded-md transition-colors">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.eye','data' => []]); ?>
<?php $component->withName('icons.eye'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit audits')): ?>
                                            <div wire:click="setRemoveFile(<?php echo e($fdid); ?>)" class="relative group cursor-pointer hover:bg-red-500 active:bg-red-600 hover:text-white p-1 rounded-md transition-colors">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.bin','data' => []]); ?>
<?php $component->withName('icons.bin'); ?>
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
                                            <div <?php if(isset($mf['id'])): ?> wire:click="toggleReplaceFileModal(<?php echo e($mf['id']); ?>)" <?php endif; ?> class="relative group cursor-pointer hover:bg-amber-500 active:bg-amber-600 hover:text-white p-1 rounded-md transition-colors">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.refresh','data' => []]); ?>
<?php $component->withName('icons.refresh'); ?>
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
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="text-gray-500 text-sm">No files found for this item.</div>
                <?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('footer', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.secondary-button','data' => ['wire:click' => 'closeFilesModal','class' => 'mr-2']]); ?>
<?php $component->withName('jet-secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'closeFilesModal','class' => 'mr-2']); ?>Close <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showEmailPdfModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showEmailPdfModal']); ?>
         <?php $__env->slot('title', null, []); ?> Email PDF Summary <?php $__env->endSlot(); ?>

         <?php $__env->slot('content', null, []); ?> 
            <div class="space-y-4">
                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'email-to','value' => 'To (comma-separated)']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'email-to','value' => 'To (comma-separated)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'email-to','type' => 'text','class' => 'w-full','wire:model.defer' => 'emailPdf.to','placeholder' => 'name@example.com, other@example.com']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'email-to','type' => 'text','class' => 'w-full','wire:model.defer' => 'emailPdf.to','placeholder' => 'name@example.com, other@example.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>

                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'email-cc','value' => 'CC (optional, comma-separated)']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'email-cc','value' => 'CC (optional, comma-separated)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'email-cc','type' => 'text','class' => 'w-full','wire:model.defer' => 'emailPdf.cc','placeholder' => 'cc1@example.com, cc2@example.com']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'email-cc','type' => 'text','class' => 'w-full','wire:model.defer' => 'emailPdf.cc','placeholder' => 'cc1@example.com, cc2@example.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>

                <p class="text-xs text-gray-500">
                    We’ll generate the PDF now and email it to the addresses above.
                </p>
            </div>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex items-center gap-2">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['wire:click' => '$set(\'showEmailPdfModal\', false)']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showEmailPdfModal\', false)']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['onclick' => 'emailPdfSummary()']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['onclick' => 'emailPdfSummary()']); ?>Send PDF <?php echo $__env->renderComponent(); ?>
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
    


        
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.outlook-email', ['contactEmails' => $contactEmails])->html();
} elseif ($_instance->childHasBeenRendered('l2670952736-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l2670952736-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2670952736-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2670952736-3');
} else {
    $response = \Livewire\Livewire::mount('global-components.outlook-email', ['contactEmails' => $contactEmails]);
    $html = $response->html();
    $_instance->logRenderedChild('l2670952736-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        

        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showNewCategoryModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showNewCategoryModal']); ?>
             <?php $__env->slot('title', null, []); ?> New Category <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div class="space-y-3">
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'top-level-name','value' => 'Top-Level Category']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'top-level-name','value' => 'Top-Level Category']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','id' => 'top-level-name','wire:model.defer' => 'newCategory.top_level','class' => 'w-full']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','id' => 'top-level-name','wire:model.defer' => 'newCategory.top_level','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'category-name','value' => 'Folder Name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'category-name','value' => 'Folder Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','id' => 'category-name','wire:model.defer' => 'newCategory.name','class' => 'w-full']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','id' => 'category-name','wire:model.defer' => 'newCategory.name','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex flex-row justify-end items-center space-x-1">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'createNewCategory']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'createNewCategory']); ?>Create <?php echo $__env->renderComponent(); ?>
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
        

        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showFileUploadModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showFileUploadModal']); ?>
             <?php $__env->slot('title', null, []); ?> Upload File <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input.filepond','data' => ['key' => 'filepond-upload-'.e($currentReferenceID).'','wire:model' => 'file']]); ?>
<?php $component->withName('input.filepond'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['key' => 'filepond-upload-'.e($currentReferenceID).'','wire:model' => 'file']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex flex-row justify-end items-center space-x-1">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'upload']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'upload']); ?>Upload <?php echo $__env->renderComponent(); ?>
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
        

        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showReplaceFileUploadModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showReplaceFileUploadModal']); ?>
             <?php $__env->slot('title', null, []); ?> Replace File <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input.filepond','data' => ['key' => 'filepond-upload-replace-'.e($currentReferenceID).'','wire:model' => 'newFile']]); ?>
<?php $component->withName('input.filepond'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['key' => 'filepond-upload-replace-'.e($currentReferenceID).'','wire:model' => 'newFile']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex flex-row justify-end items-center space-x-1">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'replaceFile']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'replaceFile']); ?>Replace <?php echo $__env->renderComponent(); ?>
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
        

        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showNewRefItemModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showNewRefItemModal']); ?>
             <?php $__env->slot('title', null, []); ?> Add Item <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div class="space-y-4">
                    <div class="w-full flex justify-center">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab-layout','data' => []]); ?>
<?php $component->withName('tabs.tab-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                            <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab','data' => ['current' => $currentTab === $tab ? true : false,'click' => '$set(\'currentTab\',\''.e($tab).'\')']]); ?>
<?php $component->withName('tabs.tab'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab === $tab ? true : false),'click' => '$set(\'currentTab\',\''.e($tab).'\')']); ?>
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
                    </div>

                    <?php if($currentTab === 'new item'): ?>
                    <div class="space-y-4">
                        <div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'item-name','value' => 'Name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'item-name','value' => 'Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'name','type' => 'text','wire:model.defer' => 'newRefItem.name']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'name','type' => 'text','wire:model.defer' => 'newRefItem.name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <div class="flex flex-row-reverse justify-end items-center gap-1">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'item-check','value' => 'Add as default?']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'item-check','value' => 'Add as default?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.checkbox','data' => ['type' => 'checkbox','id' => 'item-check','wire:model' => 'newRefItem.default']]); ?>
<?php $component->withName('jet-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'checkbox','id' => 'item-check','wire:model' => 'newRefItem.default']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($currentTab === 'existing item'): ?>
                    <div class="space-y-2">
                        <?php $__empty_1 = true; $__currentLoopData = $this->specificItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="flex gap-1 items-center">
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.checkbox','data' => ['type' => 'checkbox','id' => 'check-'.e($item->id).'','value' => ''.e($item->id).'','wire:model' => 'addingItems']]); ?>
<?php $component->withName('jet-checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'checkbox','id' => 'check-'.e($item->id).'','value' => ''.e($item->id).'','wire:model' => 'addingItems']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'check-'.e($item->id).'']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'check-'.e($item->id).'']); ?><?php echo e($item->name); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="py-6 text-gray-500 text-center">
                                All items from this folder have been added already
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex items-center gap-1">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['wire:click' => 'cancelAddItems']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'cancelAddItems']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if($currentTab === 'new item'): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'createRefItem']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'createRefItem']); ?>Create <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php elseif($currentTab === 'existing item'): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'addExistingItems']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'addExistingItems']); ?>Add Items <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        

        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.confirmation-modal','data' => ['wire:model' => 'showConfirmDeleteFileModal']]); ?>
<?php $component->withName('jet-confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showConfirmDeleteFileModal']); ?>
             <?php $__env->slot('title', null, []); ?> Remove file <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div>Are you sure you would like to delete this file?</div>
                <div class="font-bold text-gray-500">This action is irreversible</div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex items-center justify-end gap-1">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'removeFile']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'removeFile']); ?>Delete <?php echo $__env->renderComponent(); ?>
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
        
        
        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showCommentsModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showCommentsModal']); ?>
             <?php $__env->slot('title', null, []); ?> Comments <?php $__env->endSlot(); ?>
             <?php $__env->slot('content', null, []); ?> 
                

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.comment-section', ['entity' => $activeFile,'activityEntity' => $audit,'activityData' => ['path' => 'Audits / ' . $audit->client()->withTrashed()->first()->name . ' / ' . $audit->name]])->html();
} elseif ($_instance->childHasBeenRendered('l2670952736-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l2670952736-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2670952736-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2670952736-4');
} else {
    $response = \Livewire\Livewire::mount('global-components.comment-section', ['entity' => $activeFile,'activityEntity' => $audit,'activityData' => ['path' => 'Audits / ' . $audit->client()->withTrashed()->first()->name . ' / ' . $audit->name]]);
    $html = $response->html();
    $_instance->logRenderedChild('l2670952736-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('footer', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['xOn:click' => 'show = false']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click' => 'show = false']); ?>Close <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        

        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showAddUserModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showAddUserModal']); ?>
             <?php $__env->slot('title', null, []); ?> Add new user & assign <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => 'First name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'First name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'newUser.first_name','class' => 'w-full']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'newUser.first_name','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['newUser.first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-xs text-red-600 mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => 'Last name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Last name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'newUser.last_name','class' => 'w-full']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'newUser.last_name','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['newUser.last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-xs text-red-600 mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => 'Email']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'email','wire:model.defer' => 'newUser.email','class' => 'w-full']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'email','wire:model.defer' => 'newUser.email','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php $__errorArgs = ['newUser.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-xs text-red-600 mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => 'Role']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Role']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <select class="mt-1 w-full rounded border-gray-300" wire:model.defer="newUser.role">
                                <option value="Analyst">Analyst</option>
                                <option value="Client">Client</option>
                                <option value="Client Sub User">Client Sub User</option>
                            </select>
                            <?php $__errorArgs = ['newUser.role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-xs text-red-600 mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => 'Phone (optional)']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => 'Phone (optional)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model.defer' => 'newUser.phone','class' => 'w-full']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'newUser.phone','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php $__errorArgs = ['newUser.phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-xs text-red-600 mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="text-xs text-gray-500">
                        The new user will be created under the current client/company, enabled, and assigned immediately.
                        A password reset email will be sent so they can set their password.
                    </div>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['wire:click' => '$set(\'showAddUserModal\', false)']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showAddUserModal\', false)']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'saveNewUserAndAssign']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'saveNewUserAndAssign']); ?>Save & Assign <?php echo $__env->renderComponent(); ?>
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
        


        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.confirmation-modal','data' => ['wire:model' => 'showConfirmRemoveRefModal']]); ?>
<?php $component->withName('jet-confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showConfirmRemoveRefModal']); ?>
             <?php $__env->slot('title', null, []); ?> <?php echo e($deletingRef->default === 1 ? 'Remove' : 'Delete'); ?> Reference <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div>
                    Are you sure you would like to <span class="font-bold"><?php echo e($deletingRef->default === 1 ? 'remove' : 'delete'); ?></span> this reference item.
                    
                    <?php if($deletingRef->default === 1): ?>
                        <div class="text-gray-500 text-sm mt-2">
                            This will remove this reference item from this audit, however it can be re-added at a later stage.
                        </div>
                    <?php else: ?>
                        <div class="text-gray-500 text-sm mt-2">
                            This will <span class="font-bold">permanently delete</span> this reference item. This action is <span class="font-bold">irreversible.</span>
                        </div>
                    <?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex flex-row justify-end items-center gap-1">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.delete-button','data' => ['wire:click' => 'deleteReference']]); ?>
<?php $component->withName('buttons.delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'deleteReference']); ?>Delete <?php echo $__env->renderComponent(); ?>
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
        

        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.confirmation-modal','data' => ['wire:model' => 'showFileReplaceError']]); ?>
<?php $component->withName('jet-confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showFileReplaceError']); ?>
             <?php $__env->slot('title', null, []); ?> Error <?php $__env->endSlot(); ?>
             <?php $__env->slot('content', null, []); ?> 
                <div>
                    <div>File could not be replaced.</div>
                    <div>Please try deleting the file, and uploading the new one.</div>
                </div>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('footer', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['xOn:click' => 'show = false']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click' => 'show = false']); ?>Close <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        
    

    
        <div class="hidden">
            <div class="bg-green-50"></div>
            <div class="bg-green-100"></div>
            <div class="bg-green-200"></div>

            <div class="bg-sky-50"></div>
            <div class="bg-sky-100"></div>
            <div class="bg-sky-200"></div>
        </div>
    

</div>

<?php if(request('tab') === 'edit-details'): ?>
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



<?php if($showChangeClientModal): ?>
  <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60">
    <div class="relative bg-white rounded-xl shadow-2xl w-[90%] max-w-md p-6">
      <h3 class="text-lg font-bold mb-4 text-gray-800">Change Audit Client</h3>

      <div class="space-y-3">
        <label class="block text-sm font-medium text-gray-700">Select Client</label>
        <select
          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          wire:model="selectedClientId"
        >
          <?php $__currentLoopData = $this->allClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php endif; ?>

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
        const LW_ID = <?php echo \Illuminate\Support\Js::from($this->id)->toHtml() ?>;

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Fetch audit data from Livewire
        const response = await fetch("<?php echo e(route('get-audit-data', ['auditId' => $audit->id])); ?>");
        const data = await response.json();

        const auditId = "<?php echo e($audit->id); ?>";

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

        const clientName = "<?php echo e(Str::slug($audit->client()->withTrashed()->first()->name)); ?>";
        const auditName  = "<?php echo e(Str::slug($audit->name)); ?>";
        const year       = "<?php echo e(optional($audit->planned_audit_date)->year ?? now()->year); ?>";
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
            formData.append("_token", "<?php echo e(csrf_token()); ?>");
            formData.append("audit_id", "<?php echo e($audit->id); ?>");
            if (to) formData.append("to", to);
            if (cc) formData.append("cc", cc);

            try {
                const res = await fetch("<?php echo e(route('send-audit-report', ['auditId' => $audit->id])); ?>", {
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
  const AUDIT_ID   = <?php echo json_encode($audit->id, 15, 512) ?>;
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
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/audit-management/components/audit-section.blade.php ENDPATH**/ ?>