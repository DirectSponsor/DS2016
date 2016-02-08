<?php $accountType = Auth::user()->account_type; ?>
@if(count($recipients)) <table class="table data table-striped table-bordered"> @else <table> @endif
    <thead><tr>
        <th>Full Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Skrill Account</th>
        <th></th>
    </tr></thead>
    <tbody>
    @if(!count($recipients))
    <tr>
        <td colspan="6"><p>There is no recipients yet ! </p></td>
    </tr>
    @endif
    @foreach($recipients as $recipient)
    <tr>
        <td>{!! $recipient->name !!}</td>
        <td>{!! $recipient->user->username !!}</td>
        <td>{!! $recipient->user->email !!}</td>
        <td>{!! $recipient->skrill_acc !!}</td>
        <td>
            @if($accountType == 'Admin' || $accountType == 'Coordinator')
            {!! Form::button('Details',
                array('class' => 'btn btn-primary btn-sm btn-process-link',
                    'URL' => route('recipients.show', ['id' => $recipient->id])
                    )) !!}
            @endif
        </td>
    </tr>
    @endforeach
</tbody></table>