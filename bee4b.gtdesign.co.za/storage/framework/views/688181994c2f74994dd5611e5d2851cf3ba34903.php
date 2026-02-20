<?php $helperClass = app('PowerComponents\LivewirePowerGrid\Helpers\Helpers'); ?>
<?php $attributes = $attributes->exceptProps([
    'primaryKey' => null,
    'row' => null,
    'field' => null,
    'theme' => null,
    'currentTable' => null,
    'tableName' => null,
    'type' => null,
    'dropdownOptions' => null,
]); ?>
<?php foreach (array_filter(([
    'primaryKey' => null,
    'row' => null,
    'field' => null,
    'theme' => null,
    'currentTable' => null,
    'tableName' => null,
    'type' => null,
    'dropdownOptions' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div 
    x-cloak
    

    <?php if($type == 'date'): ?>
    x-init="flatpickr($($refs.editable))"
    <?php endif; ?>

    x-data="{
        ...pgEditable({
            tableName: '<?php echo e($tableName); ?>',
            id: '<?php echo e($row->{$primaryKey}); ?>',
            dataField: '<?php echo e($field); ?>',
            content: '<?php echo e($helperClass->resolveContent($currentTable, $field, $row)); ?>'
        }),
        saveFunc(newContent, val = $refs.editable.value) {
            if ($refs.editable == '' || val == '') {
                this.content = '';

                this.$wire.emit('pg:editable-' + this.tableName, {
                    id: this.id,
                    value: null,
                    field: this.dataField
                });

                this.editable = false;
                return;
            }

            document.getElementsByClassName('message')[0].style.display = 'none';

            this.$wire.emit('pg:editable-' + this.tableName, {
                id: this.id,
                value: val,
                field: this.dataField
            });

            this.editable = false;
            this.content = newContent;
        },
    }"
    >
    <?php switch($type):
            case ('select'): ?>
                <div 
                    x-show="editable" 
                    x-trap="editable"
                    class="flex gap-1 items-center"
                    >
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.select','data' => ['xOn:keydown.escape' => 'editable = false','xOn:keydown.enter' => 'saveFunc($el.options[$el.selectedIndex].text)','xRef' => 'editable']]); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:keydown.escape' => 'editable = false','x-on:keydown.enter' => 'saveFunc($el.options[$el.selectedIndex].text)','x-ref' => 'editable']); ?>
                        <option value="" selected>Select Value</option>
                        <?php $__currentLoopData = $dropdownOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($index); ?>"
                                <?php if($helperClass->resolveContent($currentTable, $field, $row) == $value): ?> selected <?php endif; ?>
                                >
                                <?php echo e($value); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    <div class="flex gap-1">
                        <div class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer" x-on:click="saveFunc($refs.editable.options[$refs.editable.selectedIndex].text)">
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
                        <div class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer" x-on:click="editable = false;">
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
                    </div>
                </div>
            <?php break; ?>
    
            <?php case ('date'): ?>
                <div x-show="editable" x-trap="editable" class="flex items-center gap-1">
                    

                    <input 
                        class="flatpickr-date w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                        x-ref="editable"
                        type="text"
                        value="<?php echo e($helperClass->resolveContent($currentTable, $field, $row)); ?>"
                        placeholder="Select date"
                        x-on:keydown.enter="saveFunc($el.value)"
                        x-on:keydown.escape="editable = false"
                    />

                    <div class="flex gap-1">
                        <div x-on:click="saveFunc($refs.editable.value)" class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer">
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
                        <div x-on:click="editable = false;" class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer" >
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
                    </div>
                </div>
            <?php break; ?>

            <?php case ('month'): ?>
                <div 
                    x-show="editable" 
                    x-trap="editable"
                    class="flex gap-1 items-center"
                    >
                    <input
                        type="month"
                        x-on:keydown.enter="saveFunc(
                            new Date(Date.parse($el.value)).toLocaleDateString('en-us', { year: 'numeric', month: 'short' }), 
                            $refs.editable.value != '' ? $refs.editable.value + '-01' : ''
                        )"
                        x-on:keydown.escape="editable = false"
                        :class="{'cursor-pointer': !editable}"
                        class="<?php echo e($theme->inputClass); ?> p-2"
                        x-ref="editable"
                        x-text="content"
                        value="2022-12"
                    />

                    <div class="flex gap-1">
                        <div 
                            x-on:click="saveFunc(
                                new Date(Date.parse($refs.editable.value)).toLocaleDateString('en-us', { year: 'numeric', month: 'short' }), 
                                $refs.editable.value != '' ? $refs.editable.value + '-01' : ''
                            )" 
                            class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer"
                            >
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
                        <div x-on:click="editable = false;" class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer">
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
                    </div>
                </div>
            <?php break; ?>

            <?php default: ?>
                <div 
                    x-show="editable"
                    class="flex gap-1 items-center"
                    >
                    <input
                        type="text"
                        x-on:keydown.enter="saveFunc($refs.editable.value)"
                        x-on:keydown.escape="editable = false"
                        :class="{'cursor-pointer': !editable}"
                        class="<?php echo e($theme->inputClass); ?> p-2"
                        x-ref="editable"
                        value="<?php echo e($helperClass->resolveContent($currentTable, $field, $row)); ?>"
                    />

                    <div class="flex gap-1">
                        <div x-on:click="saveFunc($refs.editable.value)" class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer">
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
                        <div x-on:click="() => { editable = false; $refs.editable.value = content; }" class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer" >
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
                    </div>
                </div>
    <?php endswitch; ?>

    <div
        x-on:click="editable = true; setTimeout(() => { $refs.editable.focus(); }, 120);" 
        x-show="content == '' && !editable"
        class="cursor-pointer text-gray-400"
        >
        Set...
    </div>

    <div 
        x-html="content"
        x-ref="testRef"
        class="border-b border-gray-400 cursor-pointer"
        x-show="!editable"
        x-on:click="() => {
            editable = true;
            setTimeout(() => $refs.editable.nodeName == 'SELECT' ? $refs.editable.focus() : $refs.editable.select(), 120);
        }"
    >
    </div>

    <div x-show="editable" class="text-xs text-gray-500">
        Press Enter to save and Esc to cancel
    </div>

    
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/editable.blade.php ENDPATH**/ ?>