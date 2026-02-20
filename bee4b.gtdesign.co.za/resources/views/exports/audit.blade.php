<table>
    <tr>
        <td style="font-weight: bold;">Audit Name</td>
        <td>
            {{ $auditDetails['name'] }}
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Client</td>
        <td>
            {{ $auditDetails['client'] }}
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Date</td>
        <td>
            {{ Illuminate\Support\Carbon::now()->format('Y-m-d') }}
        </td>
    </tr>

    <tr></tr>

    @foreach ($data as $folder)
        <thead>
            <tr>
                <th colspan="10" style="background-color: #4b5663; color:white; text-align:center;">
                    {{ strtoupper($folder->name) }}
                </th>
            </tr>

            <tr>
                <td style="background-color: #f2f4f6; color: #1f2938;">Status</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Name</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Date Uploaded</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Uploaded By</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Date Last Checked</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Date Requested</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Due Date</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Internal Comments</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Client Comments</td>
                <td style="background-color: #f2f4f6; color: #1f2938;">Link</td>
            </tr>
        </thead>

        <tbody>
            @foreach ($folder->referenceItems as $ref)
                <tr>
                    <td>
                        {{ $ref->files->first() ? ($ref->files->first()->status === 1 ? 'Accepted' : 'Rejected') : '' }}
                    </td>
                    <td>{{ $ref->name }}</td>
                    <td>{{ $ref->files->first() ? $ref->files->first()->date_uploaded : '' }}</td>
                    <td>{{ $ref->files->first() && $ref->files->first()->fileDetails ? $ref->files->first()->fileDetails->user->name : '' }}</td>
                    <td>{{ $ref->files->first() ? $ref->files->first()->date_last_checked : '' }}</td>
                    <td>{{ $ref->files->first() ? $ref->files->first()->date_requested : '' }}</td>
                    <td>{{ $ref->files->first() ? $ref->files->first()->due_date : '' }}</td>
                    <td>{{ $ref->files->first() ? $ref->files->first()->notes : '' }}</td>
                    <td>{{ $ref->files->first() ? $ref->files->first()->client_comments : '' }}</td>
                    <td>                        
                        @if ($ref->files->first() && $ref->files->first()->file_id !== null)
                        <a href="{{ env('APP_URL') }}/file-viewer/{{ $ref->files->first()->file_id }}">View</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr></tr>
        </tbody>
    @endforeach
</table>