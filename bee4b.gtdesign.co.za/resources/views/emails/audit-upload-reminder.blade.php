<p>Hi {{ $user->name }},</p>

<p>You’ve been assigned to the audit <strong>{{ $audit->name }}</strong>. Below is a list of files you still need to upload:</p>

<ul>
    @foreach ($files as $file)
        <li>{{ $file->file_name }}</li>
    @endforeach
</ul>

<p>Please log in to the system and upload the outstanding files at your earliest convenience.</p>

<p>Regards,<br/>BEE4Business</p>
