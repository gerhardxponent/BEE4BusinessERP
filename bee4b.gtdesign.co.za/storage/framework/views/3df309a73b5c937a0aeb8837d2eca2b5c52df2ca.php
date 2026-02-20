<div>
    
    
    <div class="grid grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $this->months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white p-4 rounded-lg">
                <div class="text-lg font-bold flex justify-between items-center">
                    <div><?php echo e($month->name); ?></div>
                    <div class="bg-indigo-500 text-white rounded-full w-8 h-8 flex justify-center items-center">
                        <div><?php echo e(count($month->clients)); ?></div>
                    </div>
                </div>

                <div>
                    <?php if(count($month->clients) != 0): ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden my-8">
                            <table class="border-collapse table-fixed w-full text-sm">
                                <thead>
                                    <tr>
                                        <th class="border-b font-medium py-3 pl-8 text-slate-400 text-left">Client</th>
                                        <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Analyst</th>
                                        <th class="border-b font-medium py-3 pl-8 text-slate-400 text-center">Audit Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    
                                    <?php $__currentLoopData = $month->clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="border-b border-gray-200 p-4 pl-8 text-slate-500">
                                            <a class="table-link" href="./clients/<?php echo e($client->id); ?>"><?php echo e($client->name); ?></a>
                                        </td>
                                        <td class="border-b border-gray-200 p-4 text-slate-500 text-center"><?php echo e($client->getAnalyst != null ? $this->generateInitials($client->getAnalyst->name) : ''); ?></td>
                                        <td class="border-b border-gray-200 p-4 pr-8 text-slate-500"><?php echo e($client->next_audit); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        
                    <?php else: ?> 
                        <div class="w-full flex justify-center items-center pt-8">
                            <div class="text-gray-500">There are no audits planned for this month</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/dashboard/components/audit-dashboard.blade.php ENDPATH**/ ?>