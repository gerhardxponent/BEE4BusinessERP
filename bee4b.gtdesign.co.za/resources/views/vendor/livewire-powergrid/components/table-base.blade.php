@props([
    'theme' => null
])
<div class="tbl-fixed">
        <table class="table power-grid-table bg-white {{ $theme->tableClass }}"
                style="{{$theme->tableStyle}}">
        <thead class="bg-gray-200 {{$theme->theadClass}}"
                style="{{$theme->theadStyle}}">
                {{ $header }}
        </thead>
        <tbody class="{{$theme->tbodyClass}} tbl-body"
                style="{{$theme->tbodyStyle}}">
                {{ $rows }}
        </tbody>
        </table>
</div>
