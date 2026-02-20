<?php $attributes = $attributes->exceptProps([
    'id' => 'select2',
    'placeholder' => '',
    'tags' => false
]); ?>
<?php foreach (array_filter(([
    'id' => 'select2',
    'placeholder' => '',
    'tags' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    x-data="{
        model: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?>,
    }"
    x-init="() => {
        select2 = $($refs.select)
            .not('.select2-hidden-accessible')
            .select2({
                width: '100%',
                placeholder: '<?php echo e($placeholder); ?>',
                tags: '<?php echo e($tags); ?>'
            });

        $($refs.select).on('change', function(event) {
            if (event.target.hasAttribute('multiple')) {
                model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
            } else {
                model = event.target.value;
            }
        });

        $($refs.select).on('select2:open', function(e) {
            $('input.select2-search__field').prop('placeholder', 'Search');
        });

        Livewire.on('updateData', function(data) {
            if('<?php echo e($attributes['name']); ?>' == data.elementName) {
                var newOption = new Option(data.text, data.id, false, false);
                $($refs.select)
                    .append(newOption)
                    .val(data.id)
                    .trigger('change');
            }
        });

        Livewire.on('clearSelect2', function() {
            $($refs.select).val('').trigger('change');
        });

        Livewire.on('updateSelect2', function() {
            $($refs.select).trigger('change');
        });

        Livewire.on('updateNamedSelect2', function(data) {
            if('<?php echo e($attributes['name']); ?>' == data.elementName) {
                $($refs.select).trigger('change');
            }
        });

        Livewire.on('setValue', function(data) {
            if('<?php echo e($attributes['name']); ?>' == data.elementName) {
                $($refs.select).val(data.id);
                $($refs.select).trigger('change');
            }
        });
    }"
    wire:ignore
    style="min-width: 200px;"
    >
    <style>
        .select2-search {
            padding: 0 !important;
            /* margin-bottom: 5px; */
        }

        .select2-selection.select2-selection--multiple,
        .select2-selection {
            height: max-content;
            background-color: white !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            width: 100% !important;
        }

        .select2-selection__rendered {
            color: black !important;
            /* width: max-content; */
            /* margin: 0 !important; */
            /* margin-top: 5px !important; */
            /* margin-left: 5px !important; */
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 5px !important;
        }

        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            border: none;
            /* box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); */
            border-radius: 0.375rem;
            min-height: 42.19px;
            font-size: 1em;  
            position: relative;
        }

        .select2-container--default .select2-selection--single {
            padding-top: 9px;
            padding-bottom: 6px;
            padding-left: 2px;
        }

        .select2-search__field {
            border: none !important;
            border-radius: 0.4rem;
            min-height: 40px;
            background-color: white !important;
            border: 1px solid #d1d5db !important;
            padding: 0 20px !important;
            margin-bottom: 10px;
        }

        textarea.select2-search__field {
            border: none !important;
            border-radius: 0.4rem;
            min-height: 40px;
            background-color: white !important;
            padding: 0 !important;
        }

        .select2-results__option {
            border-radius: 0.5rem !important;
            padding: 10px;
        }

        .select2-results__option {
            margin-bottom: 4px !important;
        }

        .select2-dropdown {
            z-index: 999999999;
            /* background-color: #F4F4F4; */
            border: none;
            margin-top: 10px;
            padding: 10px;
            border-radius: 0.6rem !important;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1) !important;
        }

        /* select2-dropdown select2-dropdown--below */

        .select2-selection__choice {
            margin-top: 0px !important;
        }

        span.select2-selection--multiple:active,
        span.select2-selection--multiple[aria-expanded=true],
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--color-indigo-300) !important;
            box-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) rgba(199, 210, 254, 0.5);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--color-white);
            border: 1px solid var(--color-gray-200) !important;
            padding-top: 2px !important;
            padding-bottom: 2px !important;
            margin-left: 0px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            padding-left: 10px;
            color: var(--color-gray-800);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            background-color: var(--color-gray-200);
            border-right: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            margin-top: 4px;
            margin-left: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background-color: var(--color-gray-300);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:active {
            background-color: var(--color-gray-400);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            padding-right: 6px;
            padding-left: 20px !important;
            max-width: 150% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            background-image: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDYiIGhlaWdodD0iNDYiIGZpbGw9IiNkMGQwZDAiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8cGF0aCBkPSJtNC41OTQgOC45MTIgNi41NTMgNy42NDZhMS4xMjYgMS4xMjYgMCAwIDAgMS43MDggMGw2LjU1Mi03LjY0NmMuNjI1LS43My4xMDctMS44NTctLjg1NC0xLjg1N0g1LjQ0N2MtLjk2MSAwLTEuNDggMS4xMjctLjg1MyAxLjg1N1oiPjwvcGF0aD4KPC9zdmc+");
            background-color: transparent;
            background-size: contain;
            border: none !important;
            height: 20px !important;
            width: 20px !important;
            margin: auto !important;
            top: 10px !important;
            left: auto !important;
            right: 8px !important;
        }
    </style>

    <select x-ref="select" id="<?php echo e($id); ?>" <?php echo e($attributes->merge(['class' => ''])); ?> style="width: 100%;">
        <?php echo e($slot); ?>

    </select>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/select2-multiple.blade.php ENDPATH**/ ?>