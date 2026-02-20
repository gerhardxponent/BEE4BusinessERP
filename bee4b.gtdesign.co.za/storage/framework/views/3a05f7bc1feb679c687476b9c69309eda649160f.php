<div>
    

    
    <div class="font-bold text-xl mb-4">Files uploaded by <?php echo e($user->name); ?></div>

    <div class="mt-2">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.components.user-files-table', ['id' => ''.e($user->id).''])->html();
} elseif ($_instance->childHasBeenRendered('l3399814967-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l3399814967-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l3399814967-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l3399814967-0');
} else {
    $response = \Livewire\Livewire::mount('users.components.user-files-table', ['id' => ''.e($user->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('l3399814967-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/users/components/files.blade.php ENDPATH**/ ?>