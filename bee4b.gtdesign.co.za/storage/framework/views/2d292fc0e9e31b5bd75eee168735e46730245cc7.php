<div class="items-center justify-between sm:flex">
    <div class="items-center justify-between w-full sm:flex-1 sm:flex">
        <?php if($recordCount === 'full'): ?>
            <div>
                <div class="mr-2 leading-5 text-center text-gray-700 text-md dark:text-gray-300 sm:text-right">
                    <?php echo e(trans('livewire-powergrid::datatable.pagination.showing')); ?>

                    <span class="font-semibold firstItem"><?php echo e($paginator->firstItem()); ?></span>
                    <?php echo e(trans('livewire-powergrid::datatable.pagination.to')); ?>

                    <span class="font-semibold lastItem"><?php echo e($paginator->lastItem()); ?></span>
                    <?php echo e(trans('livewire-powergrid::datatable.pagination.of')); ?>

                    <span class="font-semibold total"><?php echo e($paginator->total()); ?></span>
                    <?php echo e(trans('livewire-powergrid::datatable.pagination.results')); ?>

                </div>
            </div>
        <?php elseif($recordCount === 'short'): ?>
            <div>
                <p class="mr-2 leading-5 text-center text-gray-700 text-md dark:text-gray-300">
                    <span class="font-semibold firstItem"> <?php echo e($paginator->firstItem()); ?></span>
                    -
                    <span class="font-semibold lastItem"> <?php echo e($paginator->lastItem()); ?></span>
                    |
                    <span class="font-semibold total"> <?php echo e($paginator->total()); ?></span>

                </p>
            </div>
        <?php elseif($recordCount === 'min'): ?>
            <div>
                <p class="mr-2 leading-5 text-center text-gray-700 text-md dark:text-gray-300">
                    <span class="font-semibold firstItem"> <?php echo e($paginator->firstItem()); ?></span>
                    -
                    <span class="font-semibold lastItem"> <?php echo e($paginator->lastItem()); ?></span>
                </p>
            </div>
        <?php endif; ?>

        <?php if($paginator->hasPages()): ?>
            <nav role="navigation" aria-label="Pagination Navigation" class="items-center justify-between sm:flex">
                <div class="flex justify-center mt-2 md:flex-none md:justify-end sm:mt-0">

                    <?php if(!$paginator->onFirstPage()): ?>

                        <a
                            class="px-2 py-1 pt-2 m-1 text-center text-white bg-gray-500 border-gray-400 rounded cursor-pointer border-1 hover:bg-gray-600 hover:border-gray-800 dark:text-gray-300"
                            wire:click="gotoPage(1)"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                            </svg>
                        </a>

                        <a class="px-2 py-1 pt-2 m-1 text-center text-white bg-gray-500 border-gray-400 rounded cursor-pointer border-1 hover:bg-gray-600 hover:border-gray-800 dark:text-gray-300"
                           wire:click="previousPage"
                           rel="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223z"/>
                            </svg>
                        </a>

                    <?php endif; ?>

                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_array($element)): ?>

                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($paginator->currentPage() > 3 && $page === 2): ?>
                                    <div class="mx-1 mt-1 text-gray-800 dark:text-gray-300">
                                        <span class="font-bold">.</span>
                                        <span class="font-bold">.</span>
                                        <span class="font-bold">.</span>
                                    </div>
                                <?php endif; ?>

                                <?php if($page == $paginator->currentPage()): ?>
                                    <span
                                        class="px-2 py-1 m-1 text-center border-gray-400 rounded cursor-pointer border-1 dark:bg-gray-700 dark:text-white dark:text-gray-300"><?php echo e($page); ?></span>
                                <?php elseif($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2): ?>
                                    <a class="px-2 py-1 m-1 text-center text-white bg-gray-500 border-gray-400 rounded cursor-pointer border-1 hover:bg-gray-600 hover:border-gray-800 dark:text-gray-300"
                                       wire:click="gotoPage(<?php echo e($page); ?>)"><?php echo e($page); ?></a>
                                <?php endif; ?>

                                <?php if($paginator->currentPage() < $paginator->lastPage() - 2  && $page === $paginator->lastPage() - 1): ?>
                                    <div class="mx-1 mt-1 text-gray-600 dark:text-gray-300">
                                        <span>.</span>
                                        <span>.</span>
                                        <span>.</span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($paginator->hasMorePages()): ?>
                        <?php if($paginator->lastPage() - $paginator->currentPage() >= 2): ?>
                            <a class="px-2 py-1 pt-2 m-1 text-center text-white bg-gray-500 border-gray-400 rounded cursor-pointer border-1 hover:bg-gray-600 hover:border-gray-800 dark:text-gray-300"
                               wire:click="nextPage"
                               rel="next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                        <a
                            class="px-2 py-1 pt-2 m-1 text-center text-white bg-gray-500 border-gray-400 rounded cursor-pointer border-1 hover:bg-gray-600 hover:border-gray-800 dark:text-gray-300"
                            wire:click="gotoPage(<?php echo e($paginator->lastPage()); ?>)"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/pagination.blade.php ENDPATH**/ ?>