@props(['disabled' => false])

{{-- <input style="background-color: #F4F4F4;" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full py-3 border-none focus:border-indigo-300 rounded-xl']) !!}> --}}
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md']) !!}>

{{-- focus:ring focus:ring-indigo-200 focus:ring-opacity-50 --}}