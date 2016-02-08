Hello {!! $name !!}, <br>
Please follow this link to confirm your email address : <a href="{!! URL::route('members.confirm',$hash) !!}">Confirm Email</a>