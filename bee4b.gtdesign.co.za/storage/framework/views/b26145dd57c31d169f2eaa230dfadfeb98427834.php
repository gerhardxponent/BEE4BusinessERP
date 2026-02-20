<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('procurement.procurement-table', [])->html();
} elseif ($_instance->childHasBeenRendered('l93972010-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l93972010-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l93972010-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l93972010-0');
} else {
    $response = \Livewire\Livewire::mount('procurement.procurement-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('l93972010-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('procurement.create-procurement', [])->html();
} elseif ($_instance->childHasBeenRendered('l93972010-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l93972010-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l93972010-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l93972010-1');
} else {
    $response = \Livewire\Livewire::mount('procurement.create-procurement', []);
    $html = $response->html();
    $_instance->logRenderedChild('l93972010-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/procurement/procurment-index.blade.php ENDPATH**/ ?>