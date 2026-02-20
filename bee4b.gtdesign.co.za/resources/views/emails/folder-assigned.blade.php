<!DOCTYPE html>
<html>
<head>
    <title>Folder Assignment Notification</title>
</head>
<body>
    <p>Hi {{ $userName }},</p>
    
    <p>You have been assigned as the responsible person for all items in the folder <strong>{{ $folderName }}</strong> under the audit <strong>{{ $auditName }}</strong>.</p>
    <p>
        Click here to view the audit:  
        <a href="{{ $auditUrl }}"><a href="{{ $auditUrl }}">BEE4Business | {{ $clientName }} | {{ $auditName }}</a></a>
    </p>

    <p>Please review your assigned items at your earliest convenience.</p>

    <p>Best regards,</p>
    <p>The BEE4Business Team</p>
</body>
</html>
