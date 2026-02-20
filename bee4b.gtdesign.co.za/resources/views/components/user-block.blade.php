<div class="flex flex-col gap-4 justify-center items-center bg-white px-8 py-6 w-full lg:w-1/2 rounded-xl">
    <div class="font-bold text-2xl">{{ $title }}</div>

    @if($editing ?? '')
    <div>
        {{ $editing ?? '' }}
    </div>
    @else
    <div class="w-20 h-20 flex justify-center items-center bg-gray-200 rounded-full">
        <span class="font-bold text-2xl">{{ $initials ?? '' }}</span>
    </div>

    <div>
        <table class="table-auto">
            <tr>
                <td class="font-bold">Name</td>
                <td class="pl-4">{{ $userName ?? '' }}</td>
            </tr>
            <tr>
                <td class="font-bold">Email</td>
                <td class="pl-4 break-words">{{ $userEmail ?? '' }}</td>
            </tr>
        </table>
    </div>
    @endif
</div>