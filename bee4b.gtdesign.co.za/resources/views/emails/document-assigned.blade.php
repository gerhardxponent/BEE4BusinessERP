<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Assignment Notification</title>
</head>
<body>
    <p>Dear {{ $userName }},</p>

    <p>You have been assigned as the responsible person for the document <strong>{{ $documentName }}</strong> in the audit <strong>{{ $auditName }}</strong>.</p>
    <p>
        Click here to view the audit:  
        <a href="{{ $auditUrl }}">BEE4Business | {{ $clientName }} | {{ $auditName }}</a>
    </p>

    <p>Please ensure that the document is handled appropriately.</p>

    <p>Thank you,</p>
    <p>BEE4Business</p>
</body>
</html>
