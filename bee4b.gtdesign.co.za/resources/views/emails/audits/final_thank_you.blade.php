@component('mail::message')
# Thank You for Submitting Your Documents

Hi {{ $audit->mailList->pluck('name')->implode(', ') }},

We have now received _all_ of your documents for the **{{ $clientName }}** audit (“{{ $auditName }}” FY{{ $year }}).  
Thank you for getting everything in on time!

Feel free to reach out to ops@bee4business.co.za if you have any questions.

<p>Regards,<br>BEE4Business</p>
@endcomponent
