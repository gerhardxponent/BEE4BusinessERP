<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>
    {{-- <h1>Hi {{ $data1['name'] }},</h1>
    <div>{{ $data1['body'] }}</div> --}}

    {{-- Data is audit list --}}
    @foreach($data as $audit)
    <div>
        @foreach ($audit->auditFiles as $file)
            
        @endforeach
    </div>
    @endforeach

    {{-- <div>
        @php
        echo $data;
        @endphp
    </div> --}}
</body>
</html>