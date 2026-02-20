<div>
    <div class="flex w-full" >
        <div class="w-1/6">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.components.sections', ['currentSection' => $currentSection])->html();
} elseif ($_instance->childHasBeenRendered('l3298916095-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3298916095-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3298916095-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3298916095-0');
} else {
    $response = \Livewire\Livewire::mount('settings.components.sections', ['currentSection' => $currentSection]);
    $html = $response->html();
    $_instance->logRenderedChild('l3298916095-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>

        <div class="w-full pl-6">
            <?php switch($currentSection):
                case ('clients'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.components.clients', [])->html();
} elseif ($_instance->childHasBeenRendered('l3298916095-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l3298916095-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3298916095-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3298916095-1');
} else {
    $response = \Livewire\Livewire::mount('settings.components.clients', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3298916095-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php case ('projects'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.components.projects', [])->html();
} elseif ($_instance->childHasBeenRendered('l3298916095-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l3298916095-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3298916095-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3298916095-2');
} else {
    $response = \Livewire\Livewire::mount('settings.components.projects', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3298916095-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php case ('audits'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.audit-defaults', [])->html();
} elseif ($_instance->childHasBeenRendered('l3298916095-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l3298916095-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3298916095-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3298916095-3');
} else {
    $response = \Livewire\Livewire::mount('audit-management.audit-defaults', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3298916095-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php case ('roles and permissions'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.components.roles-and-permissions', [])->html();
} elseif ($_instance->childHasBeenRendered('l3298916095-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l3298916095-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3298916095-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3298916095-4');
} else {
    $response = \Livewire\Livewire::mount('settings.components.roles-and-permissions', []);
    $html = $response->html();
    $_instance->logRenderedChild('l3298916095-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php default: ?>
                    <div></div>
            <?php endswitch; ?>
        </div>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/livewire/settings/main-page.blade.php ENDPATH**/ ?>