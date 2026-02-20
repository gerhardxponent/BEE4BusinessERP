<div>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'showCreateContactModal']]); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model' => 'showCreateContactModal']); ?>
         <?php $__env->slot('title', null, []); ?> New Contact <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col gap-2">
                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'module','value' => 'Module']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'module','value' => 'Module']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <select 
                            wire:model="selectedModule" 
                            <?php echo e(isset($client) ? 'disabled' : ''); ?>

                            class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            tabindex="1"
                            >
                            <option value="">Please select a module</option>
                            <?php $__currentLoopData = $contactableModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.validation-error','data' => ['field' => 'selectedModule']]); ?>
<?php $component->withName('validation-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['field' => 'selectedModule']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    

                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'name','value' => 'Name']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'name','value' => 'Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.name','id' => 'name','type' => 'text','tabindex' => '3']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model.lazy' => 'contact.name','id' => 'name','type' => 'text','tabindex' => '3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.validation-error','data' => ['field' => 'contact.name']]); ?>
<?php $component->withName('validation-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['field' => 'contact.name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    

                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'jobtitle','value' => 'Job Title']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'jobtitle','value' => 'Job Title']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.jobtitle','id' => 'jobtitle','type' => 'text','tabindex' => '5']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model.lazy' => 'contact.jobtitle','id' => 'jobtitle','type' => 'text','tabindex' => '5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        
                    </div>
                    

                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'phone-primary','value' => 'Phone Primary']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'phone-primary','value' => 'Phone Primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.phone_primary','id' => 'phone-primary','type' => 'text','tabindex' => '7']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model.lazy' => 'contact.phone_primary','id' => 'phone-primary','type' => 'text','tabindex' => '7']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        
                    </div>
                    
                </div>

                <div class="flex flex-col gap-2">
                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'record','value' => 'Record']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'record','value' => 'Record']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <select 
                            wire:model="selectedRecord" 
                            <?php echo e($selectedModule === null || isset($client) ? 'disabled' : ''); ?> 
                            class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            tabindex="2"
                            >
                            <option value="">Please select a record</option>
                            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($record->id); ?>"><?php echo e($record->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.validation-error','data' => ['field' => 'selectedRecord']]); ?>
<?php $component->withName('validation-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['field' => 'selectedRecord']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    

                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'email','value' => 'Email']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'email','value' => 'Email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.email','id' => 'email','type' => 'text','tabindex' => '6']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model.lazy' => 'contact.email','id' => 'email','type' => 'text','tabindex' => '6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.validation-error','data' => ['field' => 'contact.email']]); ?>
<?php $component->withName('validation-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['field' => 'contact.email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    

                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['for' => 'phone-secondary','value' => 'Phone Secondary']]); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'phone-secondary','value' => 'Phone Secondary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.phone_secondary','id' => 'phone-secondary','type' => 'text','tabindex' => '8']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:model.lazy' => 'contact.phone_secondary','id' => 'phone-secondary','type' => 'text','tabindex' => '8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        
                    </div>
                    
                </div>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex justify-end items-center">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.create-button','data' => ['wire:click' => 'submit']]); ?>
<?php $component->withName('create-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'submit']); ?>Create <?php echo $__env->renderComponent(); ?>
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

    <?php /*
    <div>
        <form class="space-y-2 w-1/4">
            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'module','value' => 'Module']])
<?php $component->withAttributes(['for' => 'module','value' => 'Module']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'select', ['view' => 'components.select','data' => ['wire:model' => 'selectedModule']])
<?php $component->withAttributes(['wire:model' => 'selectedModule']); ?>
                    <option value="">Please select a module</option>
                    @foreach ($contactableModules as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                 @endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'selectedModule']])
<?php $component->withAttributes(['field' => 'selectedModule']); ?>
@endComponentClass
            </div>

            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'record','value' => 'Record']])
<?php $component->withAttributes(['for' => 'record','value' => 'Record']); ?>
@endComponentClass
                <select wire:model="selectedRecord" {{ $selectedModule === null ? 'disabled' : '' }} class="disabled:bg-gray-100 disabled:text-gray-400 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Please select a record</option>
                    @foreach ($records as $record)
                    <option value="{{ $record->id }}">{{ $record->name }}</option>
                    @endforeach
                </select>
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'selectedRecord']])
<?php $component->withAttributes(['field' => 'selectedRecord']); ?>
@endComponentClass
            </div>

            

            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'firstname','value' => 'First Name']])
<?php $component->withAttributes(['for' => 'firstname','value' => 'First Name']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'jet-input', ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.firstname','id' => 'firstname','type' => 'text']])
<?php $component->withAttributes(['wire:model.lazy' => 'contact.firstname','id' => 'firstname','type' => 'text']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'contact.firstname']])
<?php $component->withAttributes(['field' => 'contact.firstname']); ?>
@endComponentClass
            </div>

            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'lastname','value' => 'Last Name']])
<?php $component->withAttributes(['for' => 'lastname','value' => 'Last Name']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'jet-input', ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.lastname','id' => 'lastname','type' => 'text']])
<?php $component->withAttributes(['wire:model.lazy' => 'contact.lastname','id' => 'lastname','type' => 'text']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'contact.lastname']])
<?php $component->withAttributes(['field' => 'contact.lastname']); ?>
@endComponentClass
            </div>

            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'jobtitle','value' => 'Job Title']])
<?php $component->withAttributes(['for' => 'jobtitle','value' => 'Job Title']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'jet-input', ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.jobtitle','id' => 'jobtitle','type' => 'text']])
<?php $component->withAttributes(['wire:model.lazy' => 'contact.jobtitle','id' => 'jobtitle','type' => 'text']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'contact.jobtitle']])
<?php $component->withAttributes(['field' => 'contact.jobtitle']); ?>
@endComponentClass
            </div>

            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'email','value' => 'Email']])
<?php $component->withAttributes(['for' => 'email','value' => 'Email']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'jet-input', ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.email','id' => 'email','type' => 'text']])
<?php $component->withAttributes(['wire:model.lazy' => 'contact.email','id' => 'email','type' => 'text']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'contact.email']])
<?php $component->withAttributes(['field' => 'contact.email']); ?>
@endComponentClass
            </div>

            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'phone-primary','value' => 'Phone Primary']])
<?php $component->withAttributes(['for' => 'phone-primary','value' => 'Phone Primary']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'jet-input', ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.phone_primary','id' => 'phone-primary','type' => 'text']])
<?php $component->withAttributes(['wire:model.lazy' => 'contact.phone_primary','id' => 'phone-primary','type' => 'text']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'contact.phone_primary']])
<?php $component->withAttributes(['field' => 'contact.phone_primary']); ?>
@endComponentClass
            </div>

            <div>
                @component('Illuminate\View\AnonymousComponent', 'jet-label', ['view' => 'jetstream::components.label','data' => ['for' => 'phone-secondary','value' => 'Phone Secondary']])
<?php $component->withAttributes(['for' => 'phone-secondary','value' => 'Phone Secondary']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'jet-input', ['view' => 'jetstream::components.input','data' => ['wire:model.lazy' => 'contact.phone_secondary','id' => 'phone-secondary','type' => 'text']])
<?php $component->withAttributes(['wire:model.lazy' => 'contact.phone_secondary','id' => 'phone-secondary','type' => 'text']); ?>
@endComponentClass
                @component('Illuminate\View\AnonymousComponent', 'validation-error', ['view' => 'components.validation-error','data' => ['field' => 'contact.phone_secondary']])
<?php $component->withAttributes(['field' => 'contact.phone_secondary']); ?>
@endComponentClass
            </div>

            @component('Illuminate\View\AnonymousComponent', 'create-button', ['view' => 'components.create-button','data' => ['wire:click.prevent' => 'submit']])
<?php $component->withAttributes(['wire:click.prevent' => 'submit']); ?>Create @endComponentClass
        </form>
    </div>
    */ ?>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/contacts/create-contact.blade.php ENDPATH**/ ?>