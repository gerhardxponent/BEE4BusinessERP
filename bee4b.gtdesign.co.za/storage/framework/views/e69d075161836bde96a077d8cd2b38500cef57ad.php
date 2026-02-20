<div>
    <?php if($showTips): ?>
    <div class="mb-4 space-y-2">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tip','data' => []]); ?>
<?php $component->withName('tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <div class="flex">
                <div>Click the</div> 
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.filter','data' => []]); ?>
<?php $component->withName('icons.filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> 
                <div>button above to filter tasks.</div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tip','data' => []]); ?>
<?php $component->withName('tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <div class="flex">
                <div>Hover on a task, and drag the</div>
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
                <div class="ml-1">icon to move it.</div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>
    <?php endif; ?>
    
    
    <div 
        x-data="{ showFilters: false }"
        x-init="Livewire.on('toggleFilters', () => { showFilters = !showFilters; })"
        >
        <div 
            x-show="showFilters" 
            x-collapse 
            class="rounded-md bg-white w-1/2"
            >
            <div class="p-4 space-y-2">
                <div class="font-bold text-lg">Filters</div>
                <div class="space-y-2">
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'typeFilter','value' => 'Type']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'typeFilter','value' => 'Type']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select','data' => ['wire:model' => 'typeFilter','id' => 'typeFilter']]); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'typeFilter','id' => 'typeFilter']); ?>
                                <option value="">All</option>
                            <?php $__currentLoopData = $this->types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type); ?>"><?php echo e($type); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>

                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'recordFilter','value' => 'Record']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'recordFilter','value' => 'Record']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select','data' => ['disabled' => !$typeFilter,'wire:model' => 'recordFilter','id' => 'recordFilter']]); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(!$typeFilter),'wire:model' => 'recordFilter','id' => 'recordFilter']); ?>
                                <option value="">All</option>
                            <?php $__currentLoopData = $this->records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($record->id); ?>"><?php echo e($record->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>

                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'boardFilter','value' => 'Board']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'boardFilter','value' => 'Board']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select','data' => ['disabled' => !$typeFilter || !$recordFilter,'wire:model' => 'boardFilter','id' => 'boardFilter']]); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(!$typeFilter || !$recordFilter),'wire:model' => 'boardFilter','id' => 'boardFilter']); ?>
                            <option value="">All</option>
                            <?php $__currentLoopData = $this->boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($board->id); ?>"><?php echo e($board->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="w-full flex justify-end">
        <div wire:click="toggleSort" class="cursor-pointer flex bg-gray-200 hover:bg-gray-300 active:bg-gray-400 p-2 rounded text-sm text-gray-900 font-bold">
            <?php if($sortByDate): ?>
                <div class="flex justify-start items-center gap-1">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.sort','data' => ['size' => '18']]); ?>
<?php $component->withName('icons.sort'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <div>Sort by position</div>
                </div>
            <?php else: ?>
                <div class="flex justify-start items-center gap-1">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.sort','data' => ['size' => '18']]); ?>
<?php $component->withName('icons.sort'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '18']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <div>Sort by due date</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div wire:sortable="updateGroupOrder" wire:sortable-group="updateTaskOrder" class="grid grid-cols-3 gap-8 w-full kanban mt-4">
        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php 
                // $currentTasks = $this->tasks->where('status_id', $status->id)->sortBy('status_position')->when($sortByDate, function ($query) {
                //     $query->sortBy('created_at');
                // });

                if ($sortByDate) 
                    $currentTasks = $this->tasks->where('status_id', $status->id)->sortBy(fn ($item) => $item->deadline ?: PHP_INT_MAX);
                else 
                    $currentTasks = $this->tasks->where('status_id', $status->id)->sortBy('status_position');
            ?>

            <div>
                <div class="px-2 py-4 rounded-md" style="background-color: #eff0f2">
                    <div wire:key="group-<?php echo e($status->id); ?>">
                        <div class="flex gap-2 items-center">
                            <div class="text-lg font-bold bg-indigo-200 text-indigo-900 w-8 h-8 flex justify-center items-center rounded-full">
                                <div><?php echo e(count($currentTasks)); ?></div>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <div class="font-bold text-lg"><?php echo e($status->name); ?></div>
                            </div>
                        </div>
                    </div>

                    <div wire:sortable-group.item-group="<?php echo e($status->id); ?>" class="flex flex-col gap-2 py-4">
                        <?php $__currentLoopData = $currentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div 
                                wire:key="task-<?php echo e($task->id); ?>" 
                                wire:sortable-group.item="<?php echo e($task->id); ?>" 
                                class="bg-white p-4 rounded-md flex justify-between items-center group"
                                x-data="{ 
                                    expanded: false, 
                                    expandText: false,
                                    
                                }"
                                >
                                <div class="space-y-2">
                                    <div>
                                        <div class="flex gap-2 items-center text-lg font-bold">
                                            <div 
                                                class="w-5 h-5 rounded-full border border-gray-300 flex justify-center items-center cursor-pointer
                                                <?php if($task->status_id == 1): ?>     bg-green-500
                                                <?php elseif($task->status_id == 2): ?> bg-white
                                                <?php elseif($task->status_id == 3): ?> bg-gray-600
                                                <?php endif; ?>" 
                                                wire:click="changeStatus(<?php echo e($task->id); ?>)"
                                                >
                                                <?php if($task->status_id == 3): ?>
                                                <div class="text-white">
                                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.check','data' => ['size' => '16']]); ?>
<?php $component->withName('icons.check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '16']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div 
                                                class="cursor-pointer hover:text-blue-600 hover:underline" 
                                                wire:click="$emit('taskClicked', '<?php echo e($task->id); ?>')"
                                                >
                                                <?php echo e($task->name); ?>

                                            </div>
                                        </div>
                                        <div class="text-gray-600"><?php echo e(isset($task->board->boardable) ? $task->board->boardable->name : ''); ?></div>
                                    </div>

                                    <div>
                                        
                                        
                                        
                                        <div>
                                            <div x-show="!expandText">
                                                <?php echo e(Str::limit($task->description, 120)); ?>

                                                
                                            </div>
                                            <div x-show="expandText">
                                                <?php echo e($task->description); ?>

                                            </div>
                                            <?php if(Str::length($task->description) > 120): ?>
                                            <button 
                                                x-on:click="expandText = !expandText" 
                                                x-text="expandText ? 'Hide' : 'Read more'"
                                                class="text-blue-500 hover:underline text-sm"
                                                >
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div>
                                        <?php if($task->deadline): ?>
                                        <div class="flex gap-1 text-gray-500 text-sm items-center">
                                            <div>Due Date: </div>
                                            
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.inline-edit','data' => ['original' => $task->deadline,'entityId' => $task->id,'field' => 'deadline','name' => 'task-deadline','type' => 'date','id' => ''.e($task->id).'-task-deadline']]); ?>
<?php $component->withName('inline-edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['original' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task->deadline),'entityId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task->id),'field' => 'deadline','name' => 'task-deadline','type' => 'date','id' => ''.e($task->id).'-task-deadline']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($status->id == 3): ?>
                                        <div class="flex gap-1 text-gray-500 text-sm">
                                            <div>Completed on:</div>
                                            <div><?php echo e($task->completed_at); ?></div>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.initials','data' => ['userNames' => $task->assignedUsers->pluck('name')->toArray()]]); ?>
<?php $component->withName('initials'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['userNames' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task->assignedUsers->pluck('name')->toArray())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                        
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex gap-1 flex-wrap">
                                            <?php $__currentLoopData = $task->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="bg-<?php echo e($tag->colour->code); ?>-100 font-bold text-sm text-<?php echo e($tag->colour->code); ?>-900 px-4 py-1 rounded-md">
                                                <?php echo e(ucfirst($tag->name)); ?>

                                            </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if(!$sortByDate): ?>
                                <div wire:sortable-group.handle class="text-gray-400 cursor-grab opacity-0 group-hover:opacity-100 transition-opacity">
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
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/global-components/kanban.blade.php ENDPATH**/ ?>