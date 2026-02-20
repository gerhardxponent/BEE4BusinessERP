<?php $attributes = $attributes->exceptProps([
    'theme' => '',
    'inline' => null,
    'multiSelect' => null,
    'column' => null,
    'tableName' => null,
    'selected' => [],
]); ?>
<?php foreach (array_filter(([
    'theme' => '',
    'inline' => null,
    'multiSelect' => null,
    'column' => null,
    'tableName' => null,
    'selected' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    $data = collect($multiSelect['data_source'])
         ->transform(function (array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model $entry) use ($multiSelect) {
             if (is_array($entry)) {
                 $entry = collect($entry);
             }
             return [
                 'value' => $entry->only([
                     $multiSelect['value'],
                     $multiSelect['text']
                 ])
             ];
         });

    $selected = $selected[$multiSelect['dataField']]['values'] ?? []

?>
<div x-cloak
     wire:ignore.self
     x-data="pgMultiSelect({
        data: <?php echo e(json_encode($data)); ?>,
        value: '<?php echo e($multiSelect['value']); ?>',
        text: '<?php echo e($multiSelect['text']); ?>',
        tableName: '<?php echo e($tableName); ?>',
        dataField: '<?php echo e($multiSelect['dataField']); ?>',
        selected: '<?php echo e(json_encode($selected)); ?>'
     })">
    <div class="inline-block relative w-full p-2"
         style="min-width: 180px !important;">
        <div class="flex flex-col items-center relative">
            <div x-on:click="show = true" class="w-full"
                 style="min-width: 160px !important;">
                <div
                    class="my-2 border focus:bg-white focus:border-gray-500 border-gray-300 dark:border-gray-500 rounded flex">
                    <div class="flex flex-auto flex-wrap">
                        <div x-cloak
                             x-show="selected.length > 0"
                             x-text="selected.length"
                             class="text-sm text-gray-500 flex p-1 dark:text-gray-200 items-center justify-center"></div>
                        <template x-for="(option, index) in selected" :key="index">
                            <div
                                class="flex justify-center items-center m-1 cursor-pointer inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 text-sm font-medium bg-gray-200 text-gray-700 dark:bg-gray-500 dark:text-gray-900">
                                <div
                                    class="pl-0 align-middle cursor-pointer hover:text-black hover:text-current dark:text-gray-300 text-left text-xs font-medium text-gray-700 tracking-wider"
                                    x-text="option.text"></div>

                                <button type="button"
                                        x-on:click="remove(option.value)"
                                        class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-200 hover:text-gray-500 focus:outline-none focus:bg-gray-500 focus:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-500">
                                    <span class="sr-only"></span>
                                    <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                        <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/>
                                    </svg>
                                </button>

                            </div>
                        </template>
                        <div x-show="selected.length === 0" class="flex-1">
                            <input readonly
                                   x-ref="multi_select"
                                   placeholder="<?php echo e(trans($column->placeholder) ?: trans('livewire-powergrid::datatable.multi_select.select')); ?>"
                                   class="w-full block bg-gray-50 text-gray-700 py-2 text-sm px-3 leading-tight focus:outline-none dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-400"
                                   x-bind:value="selectedValues()"
                            >
                        </div>
                    </div>
                    <div
                        class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex bg-gray-50 items-center border-gray-200 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-400">

                        <button type="button" x-show="show" x-on:click="show = true"
                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none dark:text-gray-200">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.icons.up','data' => ['class' => 'w-4 h-4 text-gray-400 dark:text-gray-200 cursor-pointer']]); ?>
<?php $component->withName('livewire-powergrid::icons.up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-gray-400 dark:text-gray-200 cursor-pointer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </button>
                        <button type="button" x-show="!show" @click="show = false"
                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none dark:text-gray-200">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.icons.down','data' => ['class' => 'w-4 h-4 text-gray-400 dark:text-gray-200 cursor-pointer']]); ?>
<?php $component->withName('livewire-powergrid::icons.down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-gray-400 dark:text-gray-200 cursor-pointer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full px-4">
                <div x-show="show"
                     x-cloak
                     x-transition.origin.top
                     class="absolute rounded-lg overflow-hidden z-100 shadow-md top-100 border border-gray-300 bg-white z-50 w-full left-0 rounded max-h-select overflow-y-auto dark:bg-gray-700 dark:border-gray-400"
                     x-on:click.away="show = false">
                    <div class="flex flex-col w-full">
                        <template x-for="(option,index) in options" :key="index">
                            <div>
                                <div
                                    x-show="option.selected === false"
                                    class="relative group cursor-pointer hover:bg-gray-50 w-full border-gray-100 rounded-t border-b dark:hover:bg-gray-500 dark:hover:text-gray-300 dark:border-gray-400"
                                    x-on:click="select(option.value)">
                                    <div x-bind:class="option.selected ? 'border-gray-600' : ''"
                                         class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                                        <div class="w-full items-center flex">
                                            <div
                                                class="dark:text-gray-200 pl-0 align-middle cursor-pointer hover:text-black hover:text-current text-left text-xs font-medium text-gray-600 tracking-wider leading-6"
                                                x-model="option" x-text="option.text"></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    x-show="option.selected === true"
                                    x-on:click="remove(option.value)"
                                    class="relative group cursor-pointer hover:bg-gray-50 w-full border-gray-100 rounded-t border-b dark:hover:bg-gray-500 dark:bg-gray-600 dark:hover:text-gray-300 dark:border-gray-400">
                                    <div x-bind:class="option.selected ? 'border-gray-600' : ''"
                                         class="flex w-full items-center p-2 bg-gray-200 dark:bg-gray-600 dark:border-gray-500 border-transparent relative">
                                        <div class="w-full items-center flex">
                                            <div
                                                class="dark:text-gray-200 pl-0 align-middle cursor-pointer hover:text-black hover:text-current text-left text-xs font-medium text-gray-600 tracking-wider leading-6"
                                                x-model="option" x-text="option.text"></div>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/multi-select.blade.php ENDPATH**/ ?>