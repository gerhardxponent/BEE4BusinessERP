@props([
    'theme' => null,
    'checkbox' => null,
    'ruleHide'=> false,
    'ruleDisable' => false,
    'ruleSetAttribute' => null,
    'attribute' => null
])
@if($checkbox)
    @if($ruleHide)
        <td class="{{ $theme->thClass }}"
            style="{{ $theme->thStyle }}">
            <div class="{{ $theme->divClass }}">
            </div>
        </td>
    @elseif($ruleDisable)
        <td class="{{ $theme->thClass }}" style="{{ $theme->thStyle }}">
            <div class="{{ $theme->divClass }}">
                <label class="{{ $theme->labelClass }}">
                    <input @if(isset($ruleSetAttribute['attribute']))
                           {{ $attributes->merge([$ruleSetAttribute['attribute'] => $ruleSetAttribute['value']])->class($theme->inputClass) }}
                           @else
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           @endif
                           disabled
                           type="checkbox"/>
                </label>
            </div>
        </td>
    @else
        <td class="{{ $theme->thClass }}"
            style="{{ $theme->thStyle }}">
            <div class="{{ $theme->divClass }}">
                <label class="{{ $theme->labelClass }}">
                    <input @if(isset($ruleSetAttribute['attribute']))
                           {{ $attributes->merge([$ruleSetAttribute['attribute'] => $ruleSetAttribute['value']])->class($theme->inputClass) }}
                           @else
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           @endif
                           type="checkbox"
                           wire:model="checkboxValues"
                           value="{{ $attribute }}"/>
                </label>
            </div>
        </td>
    @endif
    @endif
