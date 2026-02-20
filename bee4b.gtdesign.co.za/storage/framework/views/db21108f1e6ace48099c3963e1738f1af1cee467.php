<div>
    <div class="flex flex-row gap-4">
        <div class="w-3/5">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('support.components.chat-list', [])->html();
} elseif ($_instance->childHasBeenRendered('l1635608530-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1635608530-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1635608530-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1635608530-0');
} else {
    $response = \Livewire\Livewire::mount('support.components.chat-list', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1635608530-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>

        <div class="w-full">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('support.components.chat-window', [])->html();
} elseif ($_instance->childHasBeenRendered('l1635608530-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1635608530-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1635608530-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1635608530-1');
} else {
    $response = \Livewire\Livewire::mount('support.components.chat-window', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1635608530-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>

    
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/support/live-chat.blade.php ENDPATH**/ ?>