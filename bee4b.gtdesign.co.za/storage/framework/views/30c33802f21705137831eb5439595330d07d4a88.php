<div>
    
    
    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('quotes.quote-table', [])->html();
} elseif ($_instance->childHasBeenRendered('l4110744882-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l4110744882-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l4110744882-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l4110744882-0');
} else {
    $response = \Livewire\Livewire::mount('quotes.quote-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('l4110744882-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/quotes/quote-index.blade.php ENDPATH**/ ?>