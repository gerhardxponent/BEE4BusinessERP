<?php if(count($enabledFilters)): ?>
    <div class="w-full pt-3 mb-3">
        <?php if(count($enabledFilters) > 1): ?>
            <span
                class="cursor-pointer inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 mr-1 text-sm font-medium bg-gray-500 text-white dark:bg-gray-600 dark:text-gray-300">
              <?php echo e(trans('livewire-powergrid::datatable.buttons.clear_all_filters')); ?>

              <button type="button"
                      wire:click.prevent="clearAllFilters()"
                      class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-white dark:text-gray-300 hover:bg-gray-400 hover:text-gray-500 focus:outline-none focus:bg-gray-500 focus:text-gray-300 dark:focus:text-gray-500">
                <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                  <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/>
                </svg>
              </button>
            </span>
        <?php endif; ?>
        <?php $__currentLoopData = $enabledFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span
                class="cursor-pointer inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 text-sm font-medium bg-gray-200 text-gray-700 dark:bg-gray-500 dark:text-gray-300">
              <?php echo e($filter['label']); ?>

              <button type="button"
                      wire:click.prevent="clearFilter('<?php echo e($field); ?>')"
                      class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-200 hover:text-gray-500 focus:outline-none focus:bg-gray-500 focus:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-500">
                <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                  <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/>
                </svg>
              </button>
        </span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/enabled-filters.blade.php ENDPATH**/ ?>