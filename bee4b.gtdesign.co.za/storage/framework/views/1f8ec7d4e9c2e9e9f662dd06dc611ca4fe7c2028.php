<div class="relative">

    
    <div class="fixed z-50 top-20 right-5 space-y-4">
        <?php if(session()->has('message')): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success','data' => ['message' => ''.e(session('message')).'']]); ?>
<?php $component->withName('toast.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['message' => ''.e(session('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php if(session()->has('error_flash')): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success','data' => ['message' => ''.e(session('error_flash')).'']]); ?>
<?php $component->withName('toast.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['message' => ''.e(session('error_flash')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
    </div>
    

    
    
        
    

    <div>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.details','data' => []]); ?>
<?php $component->withName('details'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
             <?php $__env->slot('initials', null, []); ?> <?php echo e($this->generateInitials($client->name)); ?> <?php $__env->endSlot(); ?>

             <?php $__env->slot('headerDetails', null, []); ?> 
                <div class="font-bold text-xl"><?php echo e($client->name); ?></div>
                <div class="text-gray-600"><?php echo e($client->email); ?></div>
                <div class="text-gray-600"><?php echo e($client->phone); ?></div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('headerButtons', null, []); ?> 
                <?php if($currentUser->hasRole('Client') || $currentUser->hasRole('Client Sub User') || $currentUser->can('edit clients')): ?>
                    <?php if($currentTab === 'overview' && !$editing): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.upload','data' => ['wire:click' => 'toggleCertModal']]); ?>
<?php $component->withName('buttons.upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'toggleCertModal']); ?>Upload certificate <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <?php if($editing): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:key' => 'saveClient','wire:click' => 'update','class' => 'bg-blue-500 hover:bg-blue-700 active:bg-blue-800']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:key' => 'saveClient','wire:click' => 'update','class' => 'bg-blue-500 hover:bg-blue-700 active:bg-blue-800']); ?>Save <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                    <?php if($currentTab == 'overview'): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.edit-button','data' => ['wire:click' => 'setEdit','wire:key' => 'editButton']]); ?>
<?php $component->withName('buttons.edit-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'setEdit','wire:key' => 'editButton']); ?><?php if($editing): ?> Cancel <?php else: ?> Edit <?php endif; ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.icon','data' => ['wire:click' => '$set(\'showEmailModal\', true)','colour' => 'sky']]); ?>
<?php $component->withName('buttons.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showEmailModal\', true)','colour' => 'sky']); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.mail-solid','data' => ['size' => '30']]); ?>
<?php $component->withName('icons.mail-solid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '30']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete clients')): ?>
                <?php if($currentTab === 'overview'): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.icon','data' => ['wire:click' => '$set(\'showDeleteModal\', true)','colour' => 'red']]); ?>
<?php $component->withName('buttons.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$set(\'showDeleteModal\', true)','colour' => 'red']); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.bin-solid','data' => ['size' => '30']]); ?>
<?php $component->withName('icons.bin-solid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '30']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endif; ?>
                
                <?php endif; ?>

                <div class="hidden">
                    <div class="bg-red-50"></div>
                    <div class="bg-red-100"></div>
                    <div class="bg-red-200"></div>
                    <div class="text-sky-600 active:bg-sky-200 hover:bg-sky-100"></div>
                </div>
             <?php $__env->endSlot(); ?>

            

             <?php $__env->slot('tabs', null, []); ?> 
                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab','data' => ['click' => 'changeTab(\''.e($tab).'\')','current' => $currentTab === $tab ? true : false]]); ?>
<?php $component->withName('tabs.tab'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['click' => 'changeTab(\''.e($tab).'\')','current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTab === $tab ? true : false)]); ?>
                    <?php echo e(ucfirst($tab)); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             <?php $__env->endSlot(); ?>

            <?php if($currentTab == 'projects'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                    <div wire:loading.class="opacity-50 transition-opacity">
                        
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clients.components.projects', ['clientID' => ''.e($client->id).''])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-0');
} else {
    $response = \Livewire\Livewire::mount('clients.components.projects', ['clientID' => ''.e($client->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        
                    </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>

            <?php if($currentTab == 'overview'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                <div wire:loading.class="opacity-50 transition-opacity">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clients.components.overview', ['clientID' => ''.e($client->id).''])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-1');
} else {
    $response = \Livewire\Livewire::mount('clients.components.overview', ['clientID' => ''.e($client->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>

            <?php if($currentTab == 'procurement'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.create-button','data' => ['wire:click' => '$emit(\'showCreateProcurementModal\')']]); ?>
<?php $component->withName('create-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$emit(\'showCreateProcurementModal\')']); ?>
                            Create
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('procurement.procurement-table', ['clientId' => $client->id])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-2');
} else {
    $response = \Livewire\Livewire::mount('procurement.procurement-table', ['clientId' => $client->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('procurement.create-procurement', [])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-3');
} else {
    $response = \Livewire\Livewire::mount('procurement.create-procurement', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>  
                    </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view contacts')): ?>
            <?php if($currentTab == 'contacts'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                <div>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['wire:click' => '$emit(\'toggleCreateContactModal\')']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$emit(\'toggleCreateContactModal\')']); ?>
                        <div class="flex items-center gap-1">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.plus','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <div>New Contact</div>
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>

                <div wire:loading.class="opacity-50 transition-opacity">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clients.client-contacts-table', ['client' => ''.e($client->id).''])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-4');
} else {
    $response = \Livewire\Livewire::mount('clients.client-contacts-table', ['client' => ''.e($client->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>

                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('contacts.create-contact', ['client' => $client->id])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-5');
} else {
    $response = \Livewire\Livewire::mount('contacts.create-contact', ['client' => $client->id]);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view quotes')): ?>
            <?php if($currentTab == 'quotes'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                <div wire:loading.class="opacity-50 transition-opacity">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clients.client-quotes-table', ['client' => ''.e($client->id).''])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-6');
} else {
    $response = \Livewire\Livewire::mount('clients.client-quotes-table', ['client' => ''.e($client->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>
            <?php endif; ?>

            

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view consultations')): ?>
            <?php if($currentTab == 'consultations'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                <div wire:loading.class="opacity-50 transition-opacity">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clients.client-consultations-table', ['client' => ''.e($client->id).''])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-7');
} else {
    $response = \Livewire\Livewire::mount('clients.client-consultations-table', ['client' => ''.e($client->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>
            <?php endif; ?>

            <?php if($currentTab == 'files'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.files-section', ['entity' => $client,'model' => 'App\\Models\\Clients','filePath' => 'Clients/' . $client->name])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-8');
} else {
    $response = \Livewire\Livewire::mount('global-components.files-section', ['entity' => $client,'model' => 'App\\Models\\Clients','filePath' => 'Clients/' . $client->name]);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php $__env->stopSection(); ?>
            <?php endif; ?> 

            <?php if($currentTab == 'OneDrive'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                    <div wire:loading.class="opacity-50 transition-opacity">
                        <?php if($client->onedrive_folder == null): ?>
                            <form>
                                <div>
                                    <label for="folderName">Folder Name</label>
                                    <select id="folderName" wire:model="selectedOdFolder">
                                        <option value="">Select a folder</option>
                                        <?php $__currentLoopData = $this->clientList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $odClient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($odClient->getName()); ?>"><?php echo e($odClient->getName()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click.prevent' => 'linkFolder']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click.prevent' => 'linkFolder']); ?>Link <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="space-y-6">
                                
                                <div class="flex flex-row ">
                                    <form id="oneDriveFileForm" class="mb-2 space-y-2">
                                        <input wire:model="oneDriveFile" type="file" name="oneDriveFile" id="oneDriveFile" style="display:none;"/>
                                    </form>

                                    <div class="flex flex-row items-center justify-between w-full space-x-2">
                                        
                                        <div class="flex flex-row space-x-2">
                                            <button 
                                                wire:click="previousDir"
                                                <?php if(count($curDir) == 1): ?> disabled  <?php endif; ?>
                                                class="
                                                    od-button
                                                    flex flex-row items-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500
                                                    <?php if(count($curDir) == 1): ?> bg-slate-100 text-gray-400 cursor-not-allowed <?php else: ?> text-gray-700 bg-white cursor-pointer hover:bg-gray-50 <?php endif; ?>"
                                                >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <polyline points="15 6 9 12 15 18"></polyline>
                                                </svg>
                                                <span class="font-bold">Back</span>
                                            </button>
                                        </div>
                                        

                                        
                                        

                                        
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown','data' => ['align' => 'right','triggerClasses' => 'w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500 cursor-pointer']]); ?>
<?php $component->withName('jet-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['align' => 'right','triggerClasses' => 'w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500 cursor-pointer']); ?>
                                             <?php $__env->slot('trigger', null, []); ?> 
                                                <div class="flex justify-center items-center space-x">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                    <span class="font-bold">New</span>
                                                </div>
                                             <?php $__env->endSlot(); ?>
                                             <?php $__env->slot('content', null, []); ?> 
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => []]); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                    <div id="upload-button" class="flex justify-start items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                            <path d="M12 11v6"></path>
                                                            <path d="M9.5 13.5l2.5 -2.5l2.5 2.5"></path>
                                                        </svg>
                                                        <span class="font-bold">Upload File</span>
                                                    </div>
                                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown-link','data' => ['class' => 'od-button']]); ?>
<?php $component->withName('jet-dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'od-button']); ?>
                                                    <div class="flex justify-start items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2"></path>
                                                            <line x1="12" y1="10" x2="12" y2="16"></line>
                                                            <line x1="9" y1="13" x2="15" y2="13"></line>
                                                        </svg>
                                                        <span class="font-bold" wire:click="$set('oneDriveNewFolder', true)">Create Folder</span>
                                                    </div>
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
                                

                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.input.filepond','data' => ['wire:model' => 'oneDriveFile','multiple' => true,'key' => 'od_files']]); ?>
<?php $component->withName('input.filepond'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'oneDriveFile','multiple' => true,'key' => 'od_files']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                
                                <div class="flex flex-row justify-center">
                                    <?php $__currentLoopData = $curDir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dir): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="flex flex-row items-center justify-start">
                                        <?php if($index != 0): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <polyline points="9 6 15 12 9 18"></polyline>
                                        </svg>
                                        <?php endif; ?>

                                        <?php if($index != count($curDir)-1): ?>
                                        <span 
                                            wire:key="<?php echo e($index); ?>" 
                                            wire:click="navigateTo('<?php echo e($index); ?>')"
                                            class="od-button text-blue-600 cursor-pointer text-lg"
                                            >
                                            <?php echo e($dir); ?>

                                        </span>
                                        <?php else: ?>
                                        <span class="font-bold text-lg"><?php echo e($dir); ?></span>
                                        <?php endif; ?>
                                    </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                </div>
                                

                                
                                <div class="bg-white p-4 rounded-xl transition-opacity" wire:loading.class="opacity-50">
                                    <table class="table table-auto">
                                        <thead class="border-solid border-b border-slate-200 ">
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Name</th>
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Size (KB)</th>
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Created On</th>
                                            <th class="text-left py-3 text-base" style="text-transform: capitalize;">Created By</th>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $this->odFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <?php if(isset($file->getProperties()['@microsoft.graph.downloadUrl'])): ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo e($file->getProperties()['@microsoft.graph.downloadUrl']); ?>" class="flex flex-row items-center py-2 space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file" width="50" height="50" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <desc>Download more icon variants from https://tabler-icons.io/i/file</desc>
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                            </svg>
                                                            <span><?php echo e($file->getName()); ?></span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e($file->getProperties()['@microsoft.graph.downloadUrl']); ?>">
                                                            <span><?php echo e(round($file->getSize() / 1024, 2)); ?></span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e($file->getProperties()['@microsoft.graph.downloadUrl']); ?>">
                                                            <span><?php echo e($file->getCreatedDateTime()->format('d-m-Y')); ?></span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e($file->getProperties()['@microsoft.graph.downloadUrl']); ?>">
                                                            <span><?php echo e($file->getCreatedBy()->getUser()->getDisplayName()); ?></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            
                                            <?php else: ?>
                                                <tr>
                                                    <td>
                                                        <span class="od-button cursor-pointer flex flex-row items-center py-2 space-x-2" wire:click="enterFolder('<?php echo e($file->getName()); ?>')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder" width="50" height="50" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2"></path>
                                                            </svg>
                                                        <span><?php echo e($file->getName()); ?></span>
                                                    </span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo e(round($file->getSize() / 1024, 2)); ?></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo e($file->getCreatedDateTime()->format('d-m-Y')); ?></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo e($file->getCreatedBy()->getUser()->getDisplayName()); ?></span>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        <?php endif; ?>
                        <script>
                            //opens file dialog on upload button click
                            if(document.getElementById('upload-button')) {
                                document.getElementById('upload-button').addEventListener('click', () => {
                                    document.getElementById('oneDriveFile').click();
                                    // uploading.style.display = 'block';
                                });
                            }
                        </script>
                    </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>

            <?php if($currentTab == 'activity'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                <div wire:loading.class="opacity-50 transition-opacity">
                    
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.activity', ['activities' => $client->activities()->with('user')->paginate(5),'showPath' => true,'model' => 'App\\Models\\Clients','entityID' => ''.e($client->id).''])->html();
} elseif ($_instance->childHasBeenRendered('l3878478605-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l3878478605-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3878478605-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3878478605-9');
} else {
    $response = \Livewire\Livewire::mount('global-components.activity', ['activities' => $client->activities()->with('user')->paginate(5),'showPath' => true,'model' => 'App\\Models\\Clients','entityID' => ''.e($client->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('l3878478605-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view audits')): ?>
            <?php if($currentTab == 'audits'): ?>
                <?php $__env->startSection('fullWidth'); ?>
                <div wire:loading.class="opacity-50 transition-opacity">
                    <div>
                        <div class="flex justify-between items-center">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab-layout','data' => []]); ?>
<?php $component->withName('tabs.tab-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                <?php $__currentLoopData = $clientAudits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab','data' => ['click' => 'changeAudit(\''.e($audit->id).'\')','current' => $currentAuditID == $audit->id ? true : false]]); ?>
<?php $component->withName('tabs.tab'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['click' => 'changeAudit(\''.e($audit->id).'\')','current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentAuditID == $audit->id ? true : false)]); ?>
                                        <?php echo e(ucfirst($audit->name)); ?>

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

                            <div>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create audits')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'createAudit']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'createAudit']); ?>Create Audit <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if($currentAuditID): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.components.audit-section', ['id' => ''.e($currentAuditID).''])->html();
} elseif ($_instance->childHasBeenRendered('audit-'.e($currentAuditID).'')) {
    $componentId = $_instance->getRenderedChildComponentId('audit-'.e($currentAuditID).'');
    $componentTag = $_instance->getRenderedChildComponentTagName('audit-'.e($currentAuditID).'');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('audit-'.e($currentAuditID).'');
} else {
    $response = \Livewire\Livewire::mount('audit-management.components.audit-section', ['id' => ''.e($currentAuditID).'']);
    $html = $response->html();
    $_instance->logRenderedChild('audit-'.e($currentAuditID).'', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>
                </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?> 
            <?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>

    
        
        <div>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.confirmation','data' => ['wire:model' => 'showDeleteModal']]); ?>
<?php $component->withName('modal.confirmation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showDeleteModal']); ?>
                 <?php $__env->slot('title', null, []); ?> Delete Client <?php $__env->endSlot(); ?>
                 <?php $__env->slot('content', null, []); ?> 
                    <div>
                        Are you sure you would like to delete this client?
                    </div>
                 <?php $__env->endSlot(); ?>
                 <?php $__env->slot('footer', null, []); ?> 
                    <div class="space-x-2 flex flex-row items-center justify-end">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['wire:click.prevent' => '$set(\'showDeleteModal\', false)']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click.prevent' => '$set(\'showDeleteModal\', false)']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.delete-button','data' => ['wire:click' => 'delete('.e($client->id).')']]); ?>
<?php $component->withName('buttons.delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'delete('.e($client->id).')']); ?>Delete <?php echo $__env->renderComponent(); ?>
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
        </div>
        
        
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.dialog','data' => ['wire:model' => 'showEmailModal']]); ?>
<?php $component->withName('modal.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showEmailModal']); ?>
             <?php $__env->slot('title', null, []); ?> 
                <div>New Email</div>
                <div class="text-base text-slate-400">From: <?php echo e($msEmail); ?></div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div class="space-y-4">
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'toAddress','value' => 'To']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'toAddress','value' => 'To']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'toAddress','type' => 'text','wire:model.defer' => 'emailData.recipient']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'toAddress','type' => 'text','wire:model.defer' => 'emailData.recipient']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'emailSubject','value' => 'Subject']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'emailSubject','value' => 'Subject']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => 'emailSubject','type' => 'text','wire:model.defer' => 'emailData.subject']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'emailSubject','type' => 'text','wire:model.defer' => 'emailData.subject']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'emailBody','value' => 'Body']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'emailBody','value' => 'Body']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.textarea','data' => ['id' => 'emailBody','wire:model.defer' => 'emailData.body','class' => 'w-full preserveLines','rows' => '8']]); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'emailBody','wire:model.defer' => 'emailData.body','class' => 'w-full preserveLines','rows' => '8']); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <?php if(count($attachments) > 0): ?>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'attachments','value' => 'attachments']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'attachments','value' => 'attachments']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <div id="attachments" class="space-y-2">
                            <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                            <div class="flex flex-row items-center space-x-1">
                                <span class="cursor-pointer" wire:click="removeAttachment(<?php echo e($id); ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#e11d48" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </span>
                                <span><?php echo e($attachment['Name']); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <div class="flex flex-row justify-end items-center space-x-2">
                    
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['wire:click' => 'closeEmailModal']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'closeEmailModal']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.send','data' => ['wire:click' => 'sendOutlook','id' => 'send-button','wire:loading.attr' => 'disabled']]); ?>
<?php $component->withName('buttons.send'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'sendOutlook','id' => 'send-button','wire:loading.attr' => 'disabled']); ?>Send <?php echo $__env->renderComponent(); ?>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.dialog','data' => ['wire:model' => 'showCertUploadModal']]); ?>
<?php $component->withName('modal.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showCertUploadModal']); ?>
             <?php $__env->slot('title', null, []); ?> 
                Upload Certificate
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('content', null, []); ?> 
                <div class="space-y-2">
                    <table>
                        <tr>
                            <td class="font-bold">File</td>
                            <td>
                                <input type="file" name="cert_file" id="cert_file" wire:model="cert_file" >
                                
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold">File name</td>
                            <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','wire:model' => 'cert_name']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','wire:model' => 'cert_name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        </tr>
                        <tr>
                            <td class="font-bold">Enter expiry date</td>
                            <td><?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'cert_exp_date']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'cert_exp_date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?></td>
                        </tr>
                    </table>

                    <div class="space-y-2">
                        <div class="font-bold">Enter comments</div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.textarea','data' => ['class' => 'w-full','rows' => '6','wire:model.lazy' => 'cert_comments']]); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-full','rows' => '6','wire:model.lazy' => 'cert_comments']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('footer', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['wire:click' => '$toggle(\'showCertUploadModal\')']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => '$toggle(\'showCertUploadModal\')']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.upload','data' => ['wire:click' => 'uploadCertERP']]); ?>
<?php $component->withName('buttons.upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'uploadCertERP']); ?>Upload to ERP <?php echo $__env->renderComponent(); ?>
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

        
        <form>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.dialog','data' => ['wire:model' => 'oneDriveNewFolder','maxWidth' => 'sm']]); ?>
<?php $component->withName('modal.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'oneDriveNewFolder','max-width' => 'sm']); ?>
                 <?php $__env->slot('title', null, []); ?> 
                    Create Folder
                 <?php $__env->endSlot(); ?>
                 <?php $__env->slot('content', null, []); ?> 
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'newFolderName','value' => 'Name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'newFolderName','value' => 'Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <span><?php $__errorArgs = ['newFolderName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm error">Please enter the new folder name</span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['wire:model' => 'newFolderName','id' => 'newFolderName','type' => 'text','class' => 'w-full']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'newFolderName','id' => 'newFolderName','type' => 'text','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                 <?php $__env->endSlot(); ?>
                 <?php $__env->slot('footer', null, []); ?> 
                    <div class="flex flex-row justify-end items-center">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.cancel-button','data' => ['wire:click.prevent' => '$set(\'oneDriveNewFolder\', false)']]); ?>
<?php $component->withName('buttons.cancel-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click.prevent' => '$set(\'oneDriveNewFolder\', false)']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <button 
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" 
                            wire:click.prevent="createFolder" 
                            >
                            Create
                        </button>
                    </div>
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </form>
    

    

    <div class="border-y hidden"></div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/clients/client-details.blade.php ENDPATH**/ ?>