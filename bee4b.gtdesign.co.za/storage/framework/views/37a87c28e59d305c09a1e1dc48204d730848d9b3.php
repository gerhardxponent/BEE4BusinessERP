<div>
    <div class="flex w-full" >
        <div class="w-1/6">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.components.sections', ['currentSection' => $currentSection])->html();
} elseif ($_instance->childHasBeenRendered('l1337645356-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1337645356-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1337645356-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1337645356-0');
} else {
    $response = \Livewire\Livewire::mount('settings.components.sections', ['currentSection' => $currentSection]);
    $html = $response->html();
    $_instance->logRenderedChild('l1337645356-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
} elseif ($_instance->childHasBeenRendered('l1337645356-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1337645356-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1337645356-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1337645356-1');
} else {
    $response = \Livewire\Livewire::mount('settings.components.clients', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1337645356-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php case ('projects'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.components.projects', [])->html();
} elseif ($_instance->childHasBeenRendered('l1337645356-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l1337645356-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1337645356-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1337645356-2');
} else {
    $response = \Livewire\Livewire::mount('settings.components.projects', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1337645356-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php case ('audit Fields'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-management.audit-defaults', [])->html();
} elseif ($_instance->childHasBeenRendered('l1337645356-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l1337645356-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1337645356-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1337645356-3');
} else {
    $response = \Livewire\Livewire::mount('audit-management.audit-defaults', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1337645356-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php case ('audit Templates'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('audit-template-builder', [])->html();
} elseif ($_instance->childHasBeenRendered('l1337645356-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l1337645356-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1337645356-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1337645356-4');
} else {
    $response = \Livewire\Livewire::mount('audit-template-builder', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1337645356-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                <?php case ('roles and permissions'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.components.roles-and-permissions', [])->html();
} elseif ($_instance->childHasBeenRendered('l1337645356-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l1337645356-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1337645356-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1337645356-5');
} else {
    $response = \Livewire\Livewire::mount('settings.components.roles-and-permissions', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1337645356-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php break; ?>

                 <?php case ('lead email'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('settings.application-form-settings', [])->html();
} elseif ($_instance->childHasBeenRendered('l1337645356-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l1337645356-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1337645356-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1337645356-6');
} else {
    $response = \Livewire\Livewire::mount('settings.application-form-settings', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1337645356-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/settings/main-page.blade.php ENDPATH**/ ?>