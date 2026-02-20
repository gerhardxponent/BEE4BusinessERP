<div class="space-y-6 max-w-2xl">
  <div>
    <label class="block text-sm font-medium text-gray-700">Email subject</label>
    <input type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" wire:model.defer="subject">
  </div>

  <div>
    <div class="flex items-center justify-between">
      <label class="block text-sm font-medium text-gray-700">Email body</label>
      <span class="text-xs text-gray-500">Placeholders: <code><?php echo e('{'); ?>{lead.name}}</code>, <code><?php echo e('{'); ?>{lead.company_name}}</code>, <code><?php echo e('{'); ?>{lead.email_address}}</code></span>
    </div>
    <textarea rows="8" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" wire:model.defer="body"></textarea>
  </div>

  <div class="space-y-2">
    <label class="block text-sm font-medium text-gray-700">Application form file</label>
    <input type="file" wire:model="attachment" class="block w-full text-sm" />
  <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-xs text-rose-600 mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

  
  <div class="text-xs text-gray-600 mt-1">
    Current file: <?php echo e($currentAttachmentPath ?: '— none —'); ?>

  </div>
  </div>

  <div class="flex justify-end">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['wire:click' => 'save','wire:loading.attr' => 'disabled']]); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['wire:click' => 'save','wire:loading.attr' => 'disabled']); ?>
      <span wire:loading.remove>Save</span>
      <span wire:loading>Saving...</span>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
  </div>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/settings/application-form-settings.blade.php ENDPATH**/ ?>