@props([
    /** Collection or array of objects with `id` & `name` */
    'options' => [],
    /** The initial selected IDs (array) */
    'initial' => [],
])

@php
    // grab only the id and wire:model attributes
    $idAttr    = $attributes->get('id');
    $modelAttr = $attributes->get('wire:model') 
                 ?? $attributes->get('wire:model.defer');
    // grab any extra classes you passed in
    $extraCls  = $attributes->get('class');
@endphp

<div wire:ignore>
    <select
        {{-- only render these two dynamic attributes --}}
        @if($idAttr) id="{{ $idAttr }}" @endif
        @if($modelAttr) wire:model="{{ $modelAttr }}" @endif

        multiple
        class="select2-multiple block w-full {{ $extraCls }}"
        data-initial='@json($initial)'
    >
        @foreach($options as $opt)
            <option value="{{ $opt->id }}">{{ $opt->name }}</option>
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

                // pre‐select from JSON array
                const init = $el.data('initial');
                if (Array.isArray(init)) {
                    $el.val(init).trigger('change');
                }

                // sync back to Livewire
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
