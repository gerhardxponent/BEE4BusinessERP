<?php if(auth()->check() && auth()->user()->client_id): ?>
    <script>window.location.href = "/public/audits";</script>
<?php endif; ?>

<div>
    <main class="space-y-4">
        <div class="w-full flex justify-center">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab-layout','data' => []]); ?>
<?php $component->withName('tabs.tab-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab','data' => ['current' => $currentTab === $tab ? true : false,'click' => 'changeTab(\''.e($tab).'\')']]); ?>
<?php $component->withName('tabs.tab'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab === $tab ? true : false),'click' => 'changeTab(\''.e($tab).'\')']); ?>
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

        <?php if($currentTab == "tasks"): ?>
        <div class="grid grid-cols-3 gap-4 w-full">
            <?php $__currentLoopData = $this->chartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $currentChart = $this->allChartData($client->boardsMorph->last()); ?>

                <div class="bg-white border border-gray-200 p-6">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-2">
                            <div class="bg-indigo-600 text-white p-4 w-12 h-12 flex justify-center items-center text-xl rounded">
                                <div><?php echo e($this->generateInitials($client->name)); ?></div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="text-xl"><?php echo e($client->name); ?></div>
                                <div class="text-gray-500 text-sm"><?php echo e($currentChart["remainingCount"]); ?> Tasks remaining</div>
                            </div>
                        </div>

                        <div wire:click="clientRedirect(<?php echo e($client->id); ?>)" class="text-gray-600 flex items-center gap-1 hover:bg-gray-100 px-3 py-2 rounded cursor-pointer active:bg-gray-200 text-sm">
                            <div>View All</div>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.right-arrow','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.right-arrow'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.charts.donut','data' => ['id' => 'donut'.e($index).'','allChartData' => $currentChart]]); ?>
<?php $component->withName('charts.donut'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'donut'.e($index).'','allChartData' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentChart)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
        </div>
        <?php endif; ?>

        <?php if($currentTab == "audits"): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view audits')): ?>
            <div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('dashboard.components.audit-dashboard', [])->html();
} elseif ($_instance->childHasBeenRendered('l2223783172-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2223783172-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2223783172-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2223783172-0');
} else {
    $response = \Livewire\Livewire::mount('dashboard.components.audit-dashboard', []);
    $html = $response->html();
    $_instance->logRenderedChild('l2223783172-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/dashboard/dashboard.blade.php ENDPATH**/ ?>