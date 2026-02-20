<div>
    

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('roles.role-table', [])->html();
} elseif ($_instance->childHasBeenRendered('l1121400782-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1121400782-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1121400782-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1121400782-0');
} else {
    $response = \Livewire\Livewire::mount('roles.role-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('l1121400782-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/livewire/roles/role-index.blade.php ENDPATH**/ ?>