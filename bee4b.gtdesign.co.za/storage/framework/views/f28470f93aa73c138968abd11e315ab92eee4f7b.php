<?php $attributes = $attributes->exceptProps([
    'mentionables' => [],
    'mentionID' => 'comment-block'
]); ?>
<?php foreach (array_filter(([
    'mentionables' => [],
    'mentionID' => 'comment-block'
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
        content: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?>,
    }"
    x-init='
        () => {
            var tribute = new Tribute({
                values: <?php echo json_encode($mentionables, 15, 512) ?>,
                selectTemplate: function(item) {
                    return (
                        "<span contenteditable=\"false\" class=\"text-blue-700 @" + item.original.id + "@\"><a href=\"/../users/" + item.original.id + "\">" + item.original.value + "</a></span>"
                    );
                }
            });
            tribute.attach(document.getElementById("<?php echo e($mentionID); ?>"));

            Livewire.on("commentPosted", function() {
                document.querySelector("#<?php echo e($mentionID); ?>").innerHTML = "";
            });
        }
    '
    wire:ignore
    >

    <style>
        .mention-box {
            overflow-wrap: normal;
            word-break: normal;
            min-height: 100px;
            height: max-content;
            /* border: 1px solid #d1d5db; */
        }
    </style>

    <div 
        x-ref="textarea" 
        x-on:input="content = $event.target.innerHTML" 
        id="<?php echo e($mentionID); ?>" 
        contenteditable="true" 
        style="background-color: #F3F3F3;"
        <?php echo e($attributes->merge(['class' => 'mention-box form-control w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm p-2'])); ?>

        >
    </div>
</div>

<?php /**PATH /home/appbee4businessc/public_html/resources/views/components/mention.blade.php ENDPATH**/ ?>