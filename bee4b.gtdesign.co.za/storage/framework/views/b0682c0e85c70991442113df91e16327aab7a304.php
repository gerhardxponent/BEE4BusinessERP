<div class="relative">
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

    <div id="auditSummary" class="p-6 border bg-white rounded-lg shadow-lg text-lg">
        <h2 class="text-xl font-bold mb-4">Audit Summary</h2>
        <ul class="mt-2 space-y-2">
            <li><strong>Total Uploaded:</strong> <?php echo e($this->auditSummary['totalFiles']); ?></li>
            <li><strong class="text-green-600">Total Accepted:</strong> <?php echo e($this->auditSummary['totalAccepted']); ?></li>
            <li><strong class="text-orange-600">Total Pending:</strong> <?php echo e($this->auditSummary['totalPending']); ?></li>
            <li><strong class="text-red-600">Total Rejected:</strong> <?php echo e($this->auditSummary['totalRejected']); ?></li>
            <li><strong class="text-black-600">Files Not Yet Uploaded:</strong> <?php echo e($this->auditSummary['totalEmpty']-$this->auditSummary['totalRejected']); ?></li>
        </ul>
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
                wire:model="filterUser" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
            >
                <option value="">All Users</option>
                <?php $__currentLoopData = $this->getUsersForAudit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Status Dropdown -->
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select 
                wire:model="filterStatus" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
            >
                <option value="">All Statuses</option>
                <option value="0">Pending</option>
                <option value="1">Accepted</option>
                <option value="2">Rejected</option>
            </select>
        </div>

        <!-- Date Filter -->
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Due Date</label>
            <input 
                type="date" 
                wire:model="filterDate" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2"
            />
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

            <div class="w-1/2 flex gap-2 items-center justify-end">
                <div class="w-full flex justify-end">
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
                                <div onclick="generatePdfReport('email')">Email PDF Summary</div>
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

                <!--<div class="w-full">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.search-clear','data' => ['wire:model' => 'searchString']]); ?>
<?php $component->withName('search-clear'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'searchString']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>-->
            </div>
        </div>

        <div wire:loading.class="opacity-50" wire:target="searchString" class="space-y-4 transition-opacity">
        <?php $__currentLoopData = $this->filteredData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(count($group['folders']) > 0): ?>

            <div class="bg-gray-200 p-4 mb-4 rounded">
                <h2 class="text-lg font-bold text-gray-700 uppercase">
                    <?php echo e($group['top_level']); ?>

                </h2>

                <?php $__currentLoopData = $group['folders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $folder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!in_array($folder->name, $exclude)): ?>
                        <div
                            wire:key="folder-<?php echo e($folder->id); ?>" 
                            style="box-shadow: 0px 0px 0px 1px var(--color-gray-200);"
                            class="w-full overflow-x-auto relative sm:rounded-lg shadow-xl mt-2"
                        >
                            <table class="table-auto w-full text-sm text-left overflow-hidden text-gray-600 dark:text-gray-400 border-collapse rounded-lg">
                                <thead class="relative text-xs text-gray-800 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
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
                                                    <div class="font-bold">Add</div>
                                                </div>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                            
                                            
                                                <select style="color:black !important;"
                                                    wire:change="updateFolderResponsibleUser(<?php echo e($folder->id); ?>, $event.target.value)" 
                                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
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
                                        <?php if($ref->default == 0): ?> style="box-shadow: inset 3px 0px 0px 0px #38BDF8;" <?php endif; ?> 
                                        class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 transition-opacity"
                                        wire:key="reference-<?php echo e($ref->id); ?>" 
                                        wire:loading.class="opacity-50"
                                        wire:target="setStatus(<?php echo e($ref->files->first() ? $ref->files->first()->id : ''); ?>)"
                                        >
                                        
                                        <td class="py-6 px-6 text-center">
                                            <div class="flex justify-center items-center">
                                                <?php if($ref->files->first() && $ref->files->first()->file_id !== null): ?>
                                                    <div 
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit audits')): ?>
                                                        wire:click="setStatus(<?php echo e($ref->files->first()->id); ?>)" 
                                                        <?php endif; ?>
                                                        wire:key="status-button-<?php echo e($ref->id); ?>"
                                                        >
                                                        <?php switch($ref->files->first()->status):
                                                            case (0): ?>
                                                                <div class="group relative">
                                                                    <div class="bg-amber-200 text-amber-900 max-w-max cursor-pointer rounded-md">
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
                                                                    <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-amber-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-amber-900 font-bold">
                                                                        Pending
                                                                    </div>
                                                                </div>
                                                            <?php break; ?>
                                                            
                                                            <?php case (1): ?>
                                                                <div class="group relative">
                                                                    <div class="bg-emerald-200 text-emerald-900 max-w-max cursor-pointer rounded-md">
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
                                                                    <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-emerald-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-emerald-900 font-bold">
                                                                        Accepted
                                                                    </div>
                                                                </div>
                                                            <?php break; ?>
                                                        
                                                            <?php case (2): ?>
                                                                <div class="group relative">
                                                                    <div class="bg-red-200 text-red-900 max-w-max cursor-pointer rounded-md">
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
                                                                    <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-red-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-red-900 font-bold">
                                                                        Rejected
                                                                    </div>
                                                                </div>
                                                            <?php break; ?>

                                                            <?php default: ?>
                                                                <div class="bg-amber-200 text-amber-900 max-w-max cursor-pointer rounded-md">
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
                                                        <?php endswitch; ?>
                                                    </div>                                                    
                                                <?php else: ?>
                                                <div>
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
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.simple-inline-edit','data' => ['submit' => 'setDate(Object.fromEntries(new FormData($event.target)), '.e($ref->id).')','name' => 'due_date','permission' => 'edit audits']]); ?>
<?php $component->withName('simple-inline-edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['submit' => 'setDate(Object.fromEntries(new FormData($event.target)), '.e($ref->id).')','name' => 'due_date','permission' => 'edit audits']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        

                                        
                                        <td class="py-6 px-6">
                                            <?php if(auth()->user()->hasRole('Client Sub User')): ?>
                                                
                                                <?php echo e(\App\Models\User::find($ref->files->first()->responsible_person_id)->name ?? 'Unassigned'); ?>

                                            <?php else: ?>
                                                
                                                <?php if($ref->files->first()): ?>
                                                    <select
                                                        wire:change="updateResponsiblePerson(<?php echo e($ref->files->first()->id); ?>, $event.target.value)"
                                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    >
                                                        <option value="">Select User</option>
                                                        <?php $__currentLoopData = $this->getUsersForAudit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($user->id); ?>" 
                                                                <?php if($ref->files->first()->responsible_person_id == $user->id): ?> selected <?php endif; ?>>
                                                                <?php echo e($user->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
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
                                            <?php if($ref->files->first() && $ref->files->first()->file_id !== null): ?> 
                                                <div class="space-y-2">
                                                    <div class="flex flex-row gap-1 justify-center">
                                                        <div wire:click="showFileComments(<?php echo e($ref->files->first()->id); ?>)" class="relative group cursor-pointer hover:bg-purple-500 active:bg-purple-600 hover:text-white p-1 rounded-md transition-colors">
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
                                                            <div class="absolute top-100 left-1/2 -translate-x-1/2 whitespace-nowrap mt-2 text-sm bg-purple-100 py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md text-purple-900 font-bold">
                                                                Comments
                                                            </div>
                                                        </div>
                                                        <div wire:click="download(<?php echo e($ref->files->first()->id); ?>)" class="relative group cursor-pointer hover:bg-green-500 active:bg-green-600 hover:text-white p-1 rounded-md transition-colors"> 
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
                                                        <a wire:click="setCheckedDate(<?php echo e($ref->files->first()->id); ?>)" href="../file-viewer/<?php echo e($ref->files->first()->fileDetails->id); ?>" target="_blank" class="relative group cursor-pointer hover:bg-blue-500 active:bg-blue-600 hover:text-white p-1 rounded-md transition-colors">
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
                                                        <div wire:click="setRemoveFile(<?php echo e($ref->files->first()->fileDetails->id); ?>)" class="relative group cursor-pointer hover:bg-red-500 active:bg-red-600 hover:text-white p-1 rounded-md transition-colors">
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

                                                        <div wire:click="toggleReplaceFileModal(<?php echo e($ref->files->first()->id); ?>)" class="relative group cursor-pointer hover:bg-amber-500 active:bg-amber-600 hover:text-white p-1 rounded-md transition-colors">
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
                                            <?php else: ?> 
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit audits')): ?>
                                                    
                                                    <div 
                                                        class="mt-2 p-4 border-2 border-dashed border-gray-400 rounded-md text-center"
                                                        x-data="{ isDragging: false }"
                                                        x-on:dragover.prevent="isDragging = true"
                                                        x-on:dragleave="isDragging = false"
                                                        x-on:drop.prevent="isDragging = false; $refs.uploadInput.files = event.dataTransfer.files; $wire.set('uploadingItemId', <?php echo e($ref->id); ?>); $wire.upload('uploadFile', event.dataTransfer.files[0], () => $wire.inlineUpload());"
                                                        :class="{ 'border-green-500 bg-green-100': isDragging }"
                                                    >
                                                        <input 
                                                            type="file" wire:model="uploadFile"
                                                            x-ref="uploadInput" 
                                                            class="hidden" 
                                                            accept=".pdf,.jpg,.png,.doc,.docx,.xlsx"
                                                            x-on:change="$wire.set('uploadingItemId', <?php echo e($ref->id); ?>); $wire.upload('uploadFile', $refs.uploadInput.files[0], () => $wire.inlineUpload());"
                                                        >
                                                        <p class="text-gray-600">
                                                            Drag & Drop a file here or 
                                                            <button 
                                                                type="button" 
                                                                x-on:click="$refs.uploadInput.click()" 
                                                                class="text-blue-500 underline">
                                                                Browse
                                                            </button>
                                                        </p>

                                                        
                                                        <div wire:loading wire:target="uploadFile">
                                                            <p class="text-green-600">Uploading...</p>
                                                        </div>

                                                        
                                                        <?php $__errorArgs = ['uploadFile'];
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
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
        
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.outlook-email', ['contactEmails' => $contactEmails])->html();
} elseif ($_instance->childHasBeenRendered('l2979634272-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l2979634272-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2979634272-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2979634272-3');
} else {
    $response = \Livewire\Livewire::mount('global-components.outlook-email', ['contactEmails' => $contactEmails]);
    $html = $response->html();
    $_instance->logRenderedChild('l2979634272-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'category-name','value' => 'Name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'category-name','value' => 'Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','id' => 'category-name','wire:model.defer' => 'newCategory.name']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','id' => 'category-name','wire:model.defer' => 'newCategory.name']); ?>
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
} elseif ($_instance->childHasBeenRendered('l2979634272-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l2979634272-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2979634272-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2979634272-4');
} else {
    $response = \Livewire\Livewire::mount('global-components.comment-section', ['entity' => $activeFile,'activityEntity' => $audit,'activityData' => ['path' => 'Audits / ' . $audit->client()->withTrashed()->first()->name . ' / ' . $audit->name]]);
    $html = $response->html();
    $_instance->logRenderedChild('l2979634272-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
    async function generatePdfReport(action = "download") {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Fetch audit data from Livewire
        const response = await fetch("<?php echo e(route('get-audit-data', ['auditId' => $audit->id])); ?>");
        const data = await response.json();

        const auditId = "<?php echo e($audit->id); ?>"; // Ensure this is set correctly
        console.log("Audit ID:", auditId); // DEBUG: Check if auditId is available

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

        // Summary Details
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

        // Function to add sections with page breaks
        function addSection(title, files, color) {
            if (files.length === 0) return;

            yPos = checkPageBreak(yPos, 15);
            doc.setTextColor(color);
            doc.setFontSize(14);
            doc.text(title, margin, yPos);
            yPos += 10;

            doc.setFontSize(10);
            doc.setTextColor(0, 0, 0);

            files.forEach((file, index) => {
                let text = `${index + 1}. ${file.name || 'N/A'} - ${file.uploadedBy || ''} (${file.dateUploaded || 'N/A'})`;

                let wrappedText = doc.splitTextToSize(text, 180);
                let textHeight = wrappedText.length * 6;

                yPos = checkPageBreak(yPos, textHeight);
                doc.text(wrappedText, margin, yPos);
                yPos += textHeight;
            });

            yPos += 10;
        }

        addSection("Accepted Files", acceptedFiles, "green");
        addSection("Pending Files", pendingFiles, "orange");
        addSection("Rejected Files", rejectedFiles, "red");
        addSection("Files Not Yet Uploaded", emptyFiles, "black");

        if (action === "download") {
            doc.save("Audit_Report.pdf");
        } else if (action === "email") {
            // Convert to Blob
            const pdfBlob = doc.output("blob");

            // Create FormData and send via Fetch API
            let formData = new FormData();
            formData.append("pdf", pdfBlob, "Audit_Report.pdf");
            formData.append("_token", "<?php echo e(csrf_token()); ?>");
            formData.append("audit_id", auditId);

            // FIX: Ensure the correct auditId is passed in the URL
            fetch("<?php echo e(route('send-audit-report', ['auditId' => $audit->id])); ?>", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error("Error:", error));
        }
    }
</script>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/audit-management/components/audit-section.blade.php ENDPATH**/ ?>