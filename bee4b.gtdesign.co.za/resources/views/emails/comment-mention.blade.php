<!DOCTYPE html>
<html>
<head>
    <title>Folder Assignment Notification</title>
</head>
<body>
<div style="margin-bottom:10px;">
    <strong>{{ $commenterName }}</strong> mentioned you in a comment{{ $location ? ' on: ' . $location : '' }}.
</div>

<div style="margin-bottom:20px;">
    <a href="{{ $link }}">Go to comment</a>
</div>
</body>
</html>
