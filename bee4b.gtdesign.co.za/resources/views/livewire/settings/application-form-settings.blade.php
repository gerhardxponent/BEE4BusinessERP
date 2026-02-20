<div class="space-y-6 max-w-2xl">
  <div>
    <label class="block text-sm font-medium text-gray-700">Email subject</label>
    <input type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" wire:model.defer="subject">
  </div>

  <div>
    <div class="flex items-center justify-between">
      <label class="block text-sm font-medium text-gray-700">Email body</label>
      <span class="text-xs text-gray-500">Placeholders: <code>{{ '{' }}{lead.name}}</code>, <code>{{ '{' }}{lead.company_name}}</code>, <code>{{ '{' }}{lead.email_address}}</code></span>
    </div>
    <textarea rows="8" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" wire:model.defer="body"></textarea>
  </div>

  <div class="space-y-2">
    <label class="block text-sm font-medium text-gray-700">Application form file</label>
    <input type="file" wire:model="attachment" class="block w-full text-sm" />
  @error('attachment') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror

  {{-- Show what will be saved --}}
  <div class="text-xs text-gray-600 mt-1">
    Current file: {{ $currentAttachmentPath ?: '— none —' }}
  </div>
  </div>

  <div class="flex justify-end">
    <x-jet-button wire:click="save" wire:loading.attr="disabled">
      <span wire:loading.remove>Save</span>
      <span wire:loading>Saving...</span>
    </x-jet-button>
  </div>
</div>
