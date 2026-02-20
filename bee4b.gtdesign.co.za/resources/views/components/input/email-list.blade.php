@props([
    'id' => 'emailsInput',
])

<div
    x-data="{
        emails: @entangle($attributes->wire('model')),
    }"
    x-init='() => {
        const inputContainerNode = document.querySelector("#{{ $id }}");
        const emailsInput = EmailsEditor(
            {{-- Input Target --}}
            inputContainerNode,
            {{-- On change --}}
            () => emails = emailsInput.getEmails(),
        );
    }'
    >
    <div id="{{ $id }}" x-ref="emailInput" wire:ignore class="border-none"></div>
</div>