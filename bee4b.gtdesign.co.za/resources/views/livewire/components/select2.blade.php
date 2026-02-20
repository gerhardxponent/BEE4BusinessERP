@props([
    /**  
     * Collection or array of objects with `id` & `name`  
     */
    'options' => [],
    /**  
     * The initial selected IDs (array)  
     */
    'initial' => [],
])

<div wire:ignore>
    <select
        {{ $attributes->merge(['class' => 'select2-multiple block w-full']) }}
        multiple
        {{-- pass the array as JSON, no trim --}}
        data-initial='@json($initial)'
    >
        @foreach($options as $option)
            <option value="{{ $option->id }}">
                {{ $option->name }}
            </option>
        @endforeach
    </select>
</div>

@push('scripts')
<script>
    function initSelect2Multiple() {
        document.querySelectorAll('.select2-multiple').forEach(el => {
            let $el = $(el);
            if (!$el.hasClass('select2-hidden-accessible')) {
                $el.select2({ width: 'resolve' });

                // Read the JSON array of IDs
                const initial = $el.data('initial');
                if (Array.isArray(initial)) {
                    $el.val(initial).trigger('change');
                }

                // Sync changes back to Livewire
                $el.on('change', () => {
                    const model = $el.attr('wire:model') || $el.attr('wire:model.defer');
                    if (model) {
                        @this.set(model, $el.val());
                    }
                });
            }
        });
    }

    document.addEventListener('livewire:load', initSelect2Multiple);
    Livewire.hook('message.processed', initSelect2Multiple);
</script>
@endpush
