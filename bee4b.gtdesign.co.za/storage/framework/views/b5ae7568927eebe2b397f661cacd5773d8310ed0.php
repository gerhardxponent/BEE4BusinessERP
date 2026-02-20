<div style="height: 86vh;">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('support.live-chat', [])->html();
} elseif ($_instance->childHasBeenRendered('l935683367-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l935683367-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l935683367-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l935683367-0');
} else {
    $response = \Livewire\Livewire::mount('support.live-chat', []);
    $html = $response->html();
    $_instance->logRenderedChild('l935683367-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/support/main-page.blade.php ENDPATH**/ ?>