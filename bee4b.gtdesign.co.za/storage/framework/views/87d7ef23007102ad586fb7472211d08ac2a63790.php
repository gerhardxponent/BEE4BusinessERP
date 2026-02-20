<div style="height: 86vh;">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('support.live-chat', [])->html();
} elseif ($_instance->childHasBeenRendered('l2463259773-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2463259773-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2463259773-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2463259773-0');
} else {
    $response = \Livewire\Livewire::mount('support.live-chat', []);
    $html = $response->html();
    $_instance->logRenderedChild('l2463259773-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/support/main-page.blade.php ENDPATH**/ ?>