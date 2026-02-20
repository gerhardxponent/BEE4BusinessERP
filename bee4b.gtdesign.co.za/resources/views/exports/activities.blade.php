<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Activity Type</th>
            <th>Path</th>
            <th>Date</th>
            <th>Files</th>
            <th>Comment</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->activity_type }}</td>
                <td>{{ strip_tags($item->path) }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                    @if ($item->activity_type === 'file upload')
                        {{ preg_replace('/&nbsp;/', ' ', strip_tags($item->body)) }}
                        {{-- {!! $item->body !!} --}}
                    @endif
                </td>
                <td>
                    @if ($item->activity_type === 'comment')
                        {{ preg_replace('/&nbsp;/', ' ', strip_tags($item->body)) }}
                    @endif 
                </td>
            </tr>
        @endforeach
    </tbody>
</table>