<div>
    <div class="flex flex-row gap-4">
        <div class="w-3/5">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('support.components.chat-list', [])->html();
} elseif ($_instance->childHasBeenRendered('l3295305352-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3295305352-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3295305352-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3295305352-0');
} else {
    $response = \Livewire\Livewire::mount('support.components.chat-list', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3295305352-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>

        <div class="w-full">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('support.components.chat-window', [])->html();
} elseif ($_instance->childHasBeenRendered('l3295305352-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3295305352-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3295305352-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3295305352-1');
} else {
    $response = \Livewire\Livewire::mount('support.components.chat-window', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3295305352-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>

    
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/support/live-chat.blade.php ENDPATH**/ ?>