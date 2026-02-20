{{-- existing sections… --}}
@if($this->emitSelf) {{-- ignore, just showing context --}}
@endif

{{-- Add this where you choose which sub-component to render --}}
@if($this->getParent()->currentSection === 'lead email')
  <livewire:settings.application-form-settings />
@endif
