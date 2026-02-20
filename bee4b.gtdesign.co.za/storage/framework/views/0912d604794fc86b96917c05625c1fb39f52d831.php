<?php $attributes = $attributes->exceptProps([
    'original' => '',
    'originalPlaceholder' => '',
    'model' => '',
    'entityId' => '',
    'field' => '',
    'name' => '',
    'type' => 'text',
    'id' => 'test',
    'options' => null,
    'initial' => []
]); ?>
<?php foreach (array_filter(([
    'original' => '',
    'originalPlaceholder' => '',
    'model' => '',
    'entityId' => '',
    'field' => '',
    'name' => '',
    'type' => 'text',
    'id' => 'test',
    'options' => null,
    'initial' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div 
    wire:ignore
    <?php if($type == 'date'): ?>
    x-init="() => {
        let inputEl = flatpickr(
            $('#<?php echo e($id); ?>'),
        );

        $('.document').ready(function() {
            Livewire.on('clear_flatpickr', function() {
                inputEl.clear();
            })
        });
    }"
    <?php endif; ?>

    <?php if($type == 'select2'): ?>
    x-init="() => {
        select2 = $('#<?php echo e($id); ?>')
            .not('.select2-hidden-accessible')
            .select2({
                width: '100%',
            });

        select2.val(<?php echo json_encode($initial, 15, 512) ?>).trigger('change');
    }"
    <?php endif; ?>
    x-data="{ 
        editing: false,
        focus() {
            this.editing = true;
            setTimeout(() => $refs.input.select(), 120);
        },
        save() {
            Livewire.emit('update:<?php echo e($name); ?>', $refs.input.value, '<?php echo e($model); ?>', '<?php echo e($entityId); ?>', '<?php echo e($field); ?>');
            $refs.original.innerHTML = $refs.input.value;
            this.editing = false;
        },
        cancel() {
            this.editing = false;
            $refs.input.value = '<?php echo e($original); ?>';
        },
        test() {
            console.log(<?php echo json_encode($initial, 15, 512) ?>);
        }
    }"
    >

    <div 
        x-show="!editing"
        x-on:click="focus"
        x-ref="original" 
        class="hover:underline cursor-pointer"
        >
        <?php echo e($originalPlaceholder != '' ? $originalPlaceholder : $original); ?>

    </div>

    <div x-show="editing" class="flex gap-2">
        <?php switch($type):
            case ('date'): ?>
                
                <input 
                    class="flatpickr-date w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                    id="<?php echo e($id); ?>"
                    x-ref="input"
                    type="text"
                    value="<?php echo e($original); ?>"
                    placeholder="Select date"
                    x-on:keydown.enter="save"
                    x-on:keydown.escape="cancel"
                />
                <?php break; ?>
            
            <?php case ('select2'): ?>
                <select x-ref="input" id="<?php echo e($id); ?>" multiple>
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option->id); ?>"><?php echo e($option->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php break; ?>
        
            <?php default: ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'text','value' => ''.e($original).'','xRef' => 'input','xOn:keydown.enter' => 'save','xOn:keydown.escape' => 'cancel']]); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'text','value' => ''.e($original).'','x-ref' => 'input','x-on:keydown.enter' => 'save','x-on:keydown.escape' => 'cancel']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endswitch; ?>

        

        <div class="flex gap-2 items-center">
            <button 
                x-on:click="save" 
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
            </button>
            <button 
                x-on:click="cancel"
                class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer"
                >
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
            </button>
        </div>
    </div>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/inline-edit.blade.php ENDPATH**/ ?>