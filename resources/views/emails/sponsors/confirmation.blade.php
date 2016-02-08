<img src="http://accounts.directsponsor.org/images/logo.png" /><br/><br/>
Dear {!! $name !!},<br/><br/>
Thank you for joining Direct Sponsor.
As a sponsor, you will be sending an amount of <strong>{!! $project->amount !!} in {!! $project->currency !!} </strong>
which is approximately equal to <strong>{!! $project->euro_amount !!} EUR.</strong>

The amount can be sent to recipients Skrill Account.<br/><br/>
The details of the project and sponsorship are below.<br/><br/>
Project Name : {!! $project->name !!}. <br />
Sponsorship Amount: <strong>{!! $project->amount !!} in {!! $project->currency !!} </strong>
which is approximately equal to <strong>{!! $project->euro_amount !!} EUR.</strong><br/>
Recipient: {!! $recipient->name !!}<br/>
Recipient Skrill Account: {!! $recipient->skrill_acc !!} <br/><br/>
<strong>Please follow this link to confirm your email address : <a href="{!! URL::route('sponsors.confirm',$hash) !!}">Confirm Email</a></strong><br /><br/>
Thank You<br/>
Team Direct Sponsor<br/>
<i>Freedom to live in abundance</i>
