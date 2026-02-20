<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>
    <div>
        <div style="margin-bottom: 20px;">{!! $data !!}</div>

        @if($link != '')
        <a href="{{ $link }}">View in system</a>
        @endif
    </div>
</body>
</html>