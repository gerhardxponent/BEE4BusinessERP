<?php $attributes = $attributes->exceptProps(['key']); ?>
<?php foreach (array_filter((['key']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div 
    x-data 
    wire:key=<?php echo e($key); ?>

    wire:ignore
    x-init="() => {
        const pond = FilePond.create($refs.input);
        
        pond.setOptions({
            oninit: function() {
                Livewire.on('all_files_uploaded', function() {
                    pond.removeFiles();
                });
            },
            labelIdle: '<?php echo e('<div class="flex flex-col justify-center items-center gap-3 filepond--label-action"><svg xmlns="http://www.w3.org/2000/svg"class="upload-svg rounded-full icon p-2 icon-tabler icon-tabler-cloud-upload" width="60" height="60"viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1"></path><polyline points="9 15 12 12 15 15"></polyline><line x1="12" y1="12" x2="12" y2="21"></line></svg><div><span class="font-bold">Click</span><span> or drag and drop to add files</span></div></div>'); ?>',
            allowMultiple: <?php echo e(isset($attributes['multiple']) ? 'true' : 'false'); ?>,
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    window.livewire.find('<?php echo e($_instance->id); ?>').upload('<?php echo e($attributes['wire:model']); ?>', file, load, error, progress)
                },

                revert: (filename, load) => {
                    window.livewire.find('<?php echo e($_instance->id); ?>').removeUpload('<?php echo e($attributes['wire:model']); ?>', filename, load)
                }
            },
            onprocessfiles: function() {
                Livewire.emit('filesProcessed');
            }
        });
    }">

    <style>
        .upload-svg {
            background-color: #e1e7fa;
        }

        .filepond--root .filepond--drop-label {
            height: 10em;
            cursor: pointer;
        }

        .filepond--drop-label {
            color: #3760ea;
        }

        .filepond--panel-root {
            border: 2px solid #3760ea; 
            background-color: #f1f4fe;
        }

        /* .filepond--item {
            width: calc(20% - 0.5em);
        } */

        .filepond--label-action {
            text-decoration: none;
        }
    </style>

    <input type="file" x-ref="input" /> 
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/components/input/filepond.blade.php ENDPATH**/ ?>