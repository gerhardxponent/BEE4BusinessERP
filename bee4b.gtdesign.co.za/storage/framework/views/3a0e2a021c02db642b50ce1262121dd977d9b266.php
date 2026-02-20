<div>
    <div class="grid grid-cols-1 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $audits): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <!-- $month is the key, $audits is the value -->
            <div class="bg-white p-4 rounded-lg">
                <div class="text-lg font-bold mb-4">
                    <?php echo e($month); ?>

                </div>
                
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="border-collapse table-auto w-full text-sm">
                        <thead>
                            <tr>
                                <th class="border-b py-3 pl-8 text-left text-gray-500">Audit Name</th>
                                <th class="border-b py-3 text-center text-gray-500">Completed (%)</th>
                                <th class="border-b py-3 text-center text-gray-500">Pending (%)</th>
                                <th class="border-b py-3 text-center text-gray-500">Rejected (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $audits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <!-- Iterate through the audits for each month -->
                                <tr>
                                    <td class="border-b border-gray-200 p-4 pl-8">
                                        <?php 
                                            $url = url('audits', ['audit' => $data['id']]);
                                        ?>
                                        <a class="table-link" href="<?php echo e($url); ?>"><?php echo e($data['auditName'] ?? 'N/A'); ?></a>
                                    </td>
                                    <td class="border-b border-gray-200 p-4 text-center">
                                        <?php echo e(number_format($data['percentage'], 2)); ?>%
                                    </td>
                                    <td class="border-b border-gray-200 p-4 text-center">
                                        <?php echo e(number_format($data['pendingPercentage'], 2)); ?>%
                                    </td>
                                    <td class="border-b border-gray-200 p-4 text-center">
                                        <?php echo e(number_format($data['rejectedPercentage'], 2)); ?>%
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="w-full flex justify-center items-center pt-8">
                <div class="text-gray-500">No audits available</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/dashboard/components/audit-new-dashboard.blade.php ENDPATH**/ ?>