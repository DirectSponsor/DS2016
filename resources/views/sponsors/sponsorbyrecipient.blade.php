<?php $accountType = Auth::user()->account_type; ?>
@if(!count($sponsors)) <table class="table"> @else <table class="table data table-striped table-bordered"> @endif
    <thead><tr>
        <th>Join date</th>
        <th>Username</th>
        <th>Skrill Account</th>
        <th>Projects Count</th>
        <th>Last Payment</th>
        <th>Action</th>
    </tr></thead>
    <tbody>
    @if(!count($sponsors))
    <tr>
        <td colspan="5"><p>There are no sponsors yet ! </p></td>
    </tr>
    @endif
    @foreach($sponsors as $sponsor)
    <tr>
        <td>{!! $sponsor->created_at->format('Y/m/d') !!}</td>
        <td>{!! $sponsor->user->username !!}</td>
        <td>{!! $sponsor->skrill_acc !!}</td>
        <td>{!! $sponsor->projects->count() !!}</td>
        <td>{!! $sponsor->lastRecipientPaymentDate($recipient->user->id) !!}</td>
        <td>
            @if($accountType == 'Admin')
                <a href="{!! URL::route('sponsors.projects',$sponsor->id) !!}" class="btn btn-primary btn-sm">Suspend</a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody></table>