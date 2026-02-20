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
    x-data="{ content: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?> }"
    x-init='() => {
        const tribute = new Tribute({
            values: <?php echo json_encode($mentionables, 15, 512) ?>,
            // render OUTSIDE the modal to avoid overflow/stacking issues
            menuContainer: document.body,
            // custom class for styling/z-index
            containerClass: "mentions-tribute-menu",
            // keep menu aligned with the caret
            positionMenu: true,
            selectTemplate: function(item) {
                return (
                    "<span contenteditable=\"false\" class=\"text-blue-700 @" + item.original.id + "@\">" +
                        "<a href=\"/../users/" + item.original.id + "\">" + item.original.value + "</a>" +
                    "</span>"
                );
            }
        });

        tribute.attach(document.getElementById("<?php echo e($mentionID); ?>"));

        Livewire.on("commentPosted", function() {
            const el = document.querySelector("#<?php echo e($mentionID); ?>");
            if (el) el.innerHTML = "";
        });
    }'
    wire:ignore
>
    <style>
        /* Comment editor */
        .mention-box {
            overflow-wrap: normal;
            word-break: normal;
            min-height: 100px;
            height: max-content;
        }

        /* Ensure the Tribute menu is always above your modal */
        .mentions-tribute-menu,
        body > .tribute-container {
            position: fixed !important;
            z-index: 2147483647 !important; /* above Bootstrap/Tailwind modals */
            overflow: visible !important;
        }

        /* If your modal wrapper clips children, loosen it just for this modal (optional selectors) */
        .comment-modal .modal-dialog,
        .comment-modal .modal-content {
            overflow: visible !important;
        }

        /* Container */
        .mentions-tribute-menu,
        body > .tribute-container {
        position: fixed !important;
        z-index: 2147483647 !important;
        max-width: 320px;
        max-height: 50vh;
        overflow: auto;
        background: #fff;
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 8px;
        box-shadow: 0 10px 28px rgba(0,0,0,.18), 0 2px 8px rgba(0,0,0,.1);
        }

        /* UL reset */
        .mentions-tribute-menu ul {
        margin: 0;
        padding: 6px 0;
        list-style: none;
        }

        /* Each item */
        .mentions-tribute-menu li {
        padding: 10px 12px;
        cursor: pointer;                 /* ← looks clickable */
        line-height: 1.2;
        font-size: 14px;
        }

        /* Optional row layout hook (used by menuItemTemplate) */
        .mentions-tribute-menu li .row {
        display: flex;
        align-items: center;
        gap: 10px;
        }

        /* Name styling */
        .mentions-tribute-menu li .name {
        font-weight: 500;
        color: #111827; /* tailwind gray-900 */
        }

        /* Hover state (mouse) */
        .mentions-tribute-menu li:hover {
        background: #f3f4f6;             /* tailwind gray-100 */
        }

        /* Active/keyboard-selected state (Tribute sets .highlight) */
        .mentions-tribute-menu li.highlight {
        background: #e5e7eb;             /* tailwind gray-200 */
        outline: 2px solid #6366f1;       /* subtle focus ring */
        outline-offset: -2px;
        }

        /* Subtle separators between items */
        .mentions-tribute-menu li + li {
        border-top: 1px solid rgba(0,0,0,.05);
        }

    </style>

    <div
        x-ref="textarea"
        x-on:input="content = $event.target.innerHTML"
        id="<?php echo e($mentionID); ?>"
        contenteditable="true"
        style="background-color: #F3F3F3;"
        <?php echo e($attributes->merge([
            'class' =>
                'mention-box form-control w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm p-2'
        ])); ?>

    ></div>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/mention.blade.php ENDPATH**/ ?>