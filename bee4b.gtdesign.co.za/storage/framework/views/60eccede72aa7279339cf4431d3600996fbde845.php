<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['title' => 'Create New Role'])->html();
} elseif ($_instance->childHasBeenRendered('l4152113650-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l4152113650-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l4152113650-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l4152113650-0');
} else {
    $response = \Livewire\Livewire::mount('global-components.roles-and-permissions', ['title' => 'Create New Role']);
    $html = $response->html();
    $_instance->logRenderedChild('l4152113650-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/livewire/roles/role-builder.blade.php ENDPATH**/ ?>