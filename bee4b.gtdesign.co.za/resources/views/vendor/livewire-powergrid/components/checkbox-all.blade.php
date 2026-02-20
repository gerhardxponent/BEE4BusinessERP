@props([
    'theme' => null
])
<div>
    <th scope="col" class="{{ $theme->thClass }}"
        style="{{ $theme->thStyle }}"
        wire:key="{{ md5('checkbox-all') }}">
        <div class="{{ $theme->divClass }}">
            <label class="{{ $theme->labelClass }}">
                <input class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       type="checkbox"
                       wire:click="selectCheckboxAll()"
                       wire:model.defer="checkboxAll"/>
            </label>
        </div>
    </th>
</div>
