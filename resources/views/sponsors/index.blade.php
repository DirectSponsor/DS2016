<?php
    $accountType = Auth::user()->account_type;
    if ($accountType != 'Admin') {
        $account = Auth::user()->account;
    } else {
        $account = null;
    }
    ?>
@if(count($sponsors)) <table class="table data table-striped table-bordered"> @else <table class="table"> @endif
    <thead><tr>
        <th>Name</th>
        <th>Username</th>
        <th>Skrill Account</th>
        <th>Projects</th>
        <th>Last Paid</th>
        <th>Options</th>
    </tr></thead>
    <tbody>
    @if(!count($sponsors))
    <tr>
        <td colspan="5"><p>There are no sponsors yet ! </p></td>
    </tr>
    @endif
    @foreach($sponsors as $sponsor)
    <tr>
        <td>{!! $sponsor->name !!}</td>
        <td>{!! $sponsor->user->username !!}</td>
        <td>{!! $sponsor->skrill_acc !!}</td>
        <td>{!! $sponsor->projects->count() !!}</td>
        <td>
            @if($accountType == 'Admin')
                {!! $sponsor->lastPaymentDate() !!}
            @endif
            @if($accountType == 'Coordinator')
                {!! $sponsor->lastProjectPaymentDate($account->project->id) !!}
            @endif
            @if($accountType == 'Recipient')
                {!! $sponsor->lastRecipientPaymentDate($account->user->id) !!}
            @endif
        </td>
        <td>
            @if($accountType == 'Admin')
                @if($sponsor->projects->count() > 0)
                    <a href="{!! URL::route('sponsors.projects',$sponsor->id) !!}" class="btn btn-primary btn-sm">Suspend</a>
                @endif
            @endif
        </td>
    </tr>
    @endforeach
</tbody></table>