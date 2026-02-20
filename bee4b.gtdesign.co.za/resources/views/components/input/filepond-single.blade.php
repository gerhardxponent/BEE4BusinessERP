@props(['key'])

<div 
    x-data 
    wire:key="fp_cert"
    wire:ignore
    x-init="
        FilePond.setOptions({
            labelIdle: '{{'<div class="flex flex-col justify-center items-center gap-3 filepond--label-action"><div><span class="font-bold">Click to upload</span><span> or drag and drop</span></div></div>'}}',
            allowMultiple: false,
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, () => {load(); console.log('uploaded')}, error, progress)
                },

                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                }
            },
        })
        FilePond.create($refs.input);
    ">

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

    <input type="file" x-ref="input" > 
</div>
