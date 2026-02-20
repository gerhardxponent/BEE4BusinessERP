<div class="bg-white rounded-xl shadow p-6">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-semibold text-gray-800">Edit Audit Details</h2>
  </div>

  @if($savedMessage)
    <div class="mb-4 px-4 py-2 rounded-md border border-green-200 bg-green-50 text-green-800 flex items-center justify-between">
      <div>{{ $savedMessage }}</div>
      <button type="button" class="text-green-700" wire:click="$set('savedMessage', null)">×</button>
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Planned Audit Month</label>
      <select wire:model.defer="form.planned_audit_month_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">Select month</option>
        @foreach($monthOptions as $m)
          @php $mid = is_array($m) ? ($m['id'] ?? null) : ($m->id ?? null); @endphp
          @php $mname = is_array($m) ? ($m['name'] ?? '') : ($m->name ?? ''); @endphp
          <option value="{{ $mid }}">{{ $mname }}</option>
        @endforeach
      </select>
      @error('form.planned_audit_month_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Date VA Engaged</label>
      <input type="date" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.defer="form.date_va_engaged">
      @error('form.date_va_engaged') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Next Audit Date</label>
      <input type="date" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.defer="form.next_audit_date">
      @error('form.next_audit_date') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Rating Agency</label>
      <select wire:model.defer="form.rating_agency_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">Select rating agency</option>
        @foreach($ratingAgencyOptions as $ra)
          @php $raid = is_array($ra) ? ($ra['id'] ?? null) : ($ra->id ?? null); @endphp
          @php $raname = is_array($ra) ? ($ra['name'] ?? '') : ($ra->name ?? ''); @endphp
          <option value="{{ $raid }}">{{ $raname }}</option>
        @endforeach
      </select>
      @error('form.rating_agency_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700">Analyst</label>
      <select wire:model.defer="form.rating_analyst_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">Select analyst</option>
        @foreach($analystOptions as $u)
          @php $uid = is_array($u) ? ($u['id'] ?? null) : ($u->id ?? null); @endphp
          @php $uname = is_array($u) ? ($u['name'] ?? '') : ($u->name ?? ''); @endphp
          <option value="{{ $uid }}">{{ $uname }}</option>
        @endforeach
      </select>
      @error('form.rating_analyst_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="mt-6 flex justify-end">
    <x-jet-button wire:click="save">Save</x-jet-button>
  </div>
</div>
