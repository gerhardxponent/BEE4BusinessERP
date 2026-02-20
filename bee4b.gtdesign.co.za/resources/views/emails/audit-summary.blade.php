<!DOCTYPE html>
<html>
<head>
    <title>Audit Summary Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .success {
            color: green;
        }
        .pending {
            color: orange;
        }
        h3 {
            margin-top: 20px;
        }
        .no-content {
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <p>Dear Team,</p>
    <p>Here is the summary of the documents for the audit: <strong>{{ $audit->name }}</strong>.</p>

    @foreach ($categories as $category)
        @if ($category->referenceItems->isNotEmpty()) <!-- Only show non-empty categories -->
        <h3>{{ $category->name }}</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Document Name</th>
                    <th style="width: 20%;">Responsible User</th>
                    <th style="width: 10%;">Completed</th>
                    <th style="width: 20%;">Date Due</th>
                    <th style="width: 20%;">Date Completed</th>
                </tr>
            </thead>
            <tbody>
                @php $hasContent = false; @endphp
                @foreach ($category->referenceItems as $item)
                    @foreach ($item->files as $file)
                        @php $hasContent = true; @endphp
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $file->responsibleUser->name ?? 'Unassigned' }}</td>
                            <td class="{{ $file->status ? 'success' : 'pending' }}">
                                {{ $file->status ? '✓' : '×' }}
                            </td>
                            <td>{{ $file->due_date ?? 'N/A' }}</td>
                            <td>{{ $file->date_uploaded ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @endforeach

                <!-- Display no-content row if the category has no files -->
                @if (!$hasContent)
                    <tr>
                        <td colspan="5" class="no-content">No files in this category</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @endif
    @endforeach

    <p>Regards,<br>BEE4Business</p>
</body>
</html>
