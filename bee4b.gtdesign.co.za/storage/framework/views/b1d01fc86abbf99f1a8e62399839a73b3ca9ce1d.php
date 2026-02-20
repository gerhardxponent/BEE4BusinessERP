<div
    x-data="{
        isEditing: false,
        showError: false,
        regex: <?php if ((object) ('regex') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('regex'->value()); ?>')<?php echo e('regex'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('regex'); ?>')<?php endif; ?>,
        type: <?php if ((object) ('type') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('type'->value()); ?>')<?php echo e('type'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('type'); ?>')<?php endif; ?>,
        focus: function() {
            setTimeout(() => {
                const textInput = this.$refs.textInput;
                textInput.focus();
                textInput.select();
            }, 120);
        },
        validate: function() {
            if (this.type === 'select2') {
                this.isEditing = false;
            } else {
                const regex = new RegExp(this.regex);
                const str = this.$refs.textInput.value;

                if (str.match(regex) === null) {
                    this.showError = true;
                } else {
                    this.isEditing = false;
                    this.showError = false;
                }
            }
        }
    }"
    x-cloak
    style="width: 500px"
    >
    <div x-show="!isEditing">
        <div
            <?php if($permission === '' || Auth::user()->hasPermissionTo($permission)): ?> 
            x-on:click="() => {
                isEditing = true;
                if($refs.textInput) 
                    focus();
            }" 
            <?php endif; ?>
            class="hover:underline cursor-pointer"
            >
            <?php if($origName === null || $origName === ''): ?>
            <div class="text-gray-500 underline cursor-pointer">Set...</div>
            <?php else: ?>
            <div class="group flex gap-1 <?php if($alignCenter): ?> justify-center <?php endif; ?>">
                <?php if($type === 'date'): ?>
                <span><?php echo Carbon\Carbon::parse($origName)->format($dateFormat); ?></span>
                <?php elseif($type === 'select2'): ?>
                <span><?php echo $selectOrigName; ?></span>
                <?php else: ?>
                <span><?php echo $origName; ?></span>
                <?php endif; ?>
                <span class="hidden group-hover:block">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.pencil','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.pencil'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </span>                    
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div x-show="isEditing" class="flex flex-col text-black">
        <form class="flex" wire:submit.prevent="save">
            <?php switch($type):
                case ('textarea'): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.textarea','data' => ['id' => ''.e($lineID).'','type' => 'text','xRef' => 'textInput','wire:model.lazy' => 'newName','rows' => '5','xOn:keydown.enter' => 'validate()','xOn:keydown.escape' => 'isEditing = false']]); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => ''.e($lineID).'','type' => 'text','x-ref' => 'textInput','wire:model.lazy' => 'newName','rows' => '5','x-on:keydown.enter' => 'validate()','x-on:keydown.escape' => 'isEditing = false']); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php break; ?>
                    
                <?php case ('date'): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => ''.e($lineID).'','type' => 'date','xRef' => 'textInput','wire:model.lazy' => 'newName','xOn:keydown.enter' => 'validate()','xOn:keydown.escape' => 'isEditing = false']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => ''.e($lineID).'','type' => 'date','x-ref' => 'textInput','wire:model.lazy' => 'newName','x-on:keydown.enter' => 'validate()','x-on:keydown.escape' => 'isEditing = false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    
                    <?php break; ?>

                <?php case ('select2'): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select2-multiple','data' => ['id' => ''.e($lineID).'-select2','wire:model' => 'newName','wire:key' => ''.e($lineID).'-jasaljsdhjksad']]); ?>
<?php $component->withName('select2-multiple'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => ''.e($lineID).'-select2','wire:model' => 'newName','wire:key' => ''.e($lineID).'-jasaljsdhjksad']); ?>
                        <option value="">Select Responsible Person</option>
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php break; ?>

                <?php default: ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['id' => ''.e($lineID).'','type' => 'text','xRef' => 'textInput','wire:model.lazy' => 'newName','xOn:keydown.enter' => 'validate()','xOn:keydown.escape' => 'isEditing = false']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => ''.e($lineID).'','type' => 'text','x-ref' => 'textInput','wire:model.lazy' => 'newName','x-on:keydown.enter' => 'validate()','x-on:keydown.escape' => 'isEditing = false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>                    
            <?php endswitch; ?>

            

            <div class="flex flex-row justify-center items-center ml-1 gap-1">
                <button type="button" class="p-1 text-red-600 bg-red-100 active:bg-red-300 transition-colors rounded-md flex justify-center items-center" title="Cancel" x-on:click="isEditing = false">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.close','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.close'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </button>
                <button
                    type="submit"
                    class="p-1 text-green-600 bg-green-100 active:bg-green-300 transition-colors rounded-md flex justify-center items-center"
                    title="Save"
                    
                    x-on:click="validate()"
                    >
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.check','data' => ['size' => '20']]); ?>
<?php $component->withName('icons.check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => '20']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </button>
            </div>
        </form>
        
        <?php if($type === 'line'): ?>
            <small class="text-xs text-gray-600">Enter to save, Esc to cancel</small>
        <?php endif; ?>

        <div x-show="showError" class="text-red-500 text-sm">The name cannot contain slashes or underscores.</div>
    </div>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/global-components/inline-edit.blade.php ENDPATH**/ ?>