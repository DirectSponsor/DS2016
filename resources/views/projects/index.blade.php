<?php $accountType = Auth::user()->account_type; ?>

@if($accountType == 'Admin')
<div class='container-fluid row'>
    <a href="{!!  URL::route('projects.create')  !!}" class="btn btn-primary btn-sm pull-left">New Project</a>
</div>
<br>
@endif
@if(!count($projects))
<table>
    @else
<table class="table data table-striped table-bordered">
@endif
    <thead>
        <tr>
            <th colspan="3">Project</th>
            @if($accountType == 'Sponsor')
            <th colspan="4">Recipient</th>
            @else
            <th colspan="2">Coordinator</th>
            @endif
        </tr>
        <tr>
            <th>Name</th>
            <th>Recipients</th>
            <th>Sponsors</th>
            @if($accountType == 'Sponsor')
            <th>Name</th>
            <th>Skrill ID</th>
            <th>Last Paid</th>
            <th>Due</th>
            @else
            <th>Coordinator</th>
            @endif
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
    @if(!count($projects))
    <tr>
        <td colspan="5"><p>There are no projects yet.</p></td>
    </tr>
    @endif
    @foreach($projects as $project)
    <tr>
        <td>
            <?php
                $nameAndStatus = $project->name . ' (Closed)';
                if($project->open == 1) {
                    $nameAndStatus = $project->name . ' (Open)';
                }
                ?>
            <a title="Details" class="stdlink" href="{!!  URL::route('projects.show',$project->url)  !!}">{!! $nameAndStatus !!}</a>
        </td>
        <td>{!! $project->recipients()->count() !!}</td>
        <td>{!! $project->sponsors()->count() !!}</td>
        @if($accountType == 'Sponsor')
            <?php
                $account = Auth::user()->account;
                $recipient = $project->recipientOfSponsor($account->id);
            ?>
            <td>{!! $recipient->user->account->name !!}</td>
            <td>{!! $recipient->skrill_acc !!}</td>
            <td>{!! $account->lastRecipientPaymentDate($recipient->user->id) !!}</td>
            <td>{!! $recipient->nextPaymentDueFromSponsor($account->id) !!}</td>
        @else
            <td>{!! $project->coordinator->user->username !!}</td>
        @endif
        <td>
        @if(($accountType == 'Admin') && (!$project->isFullySubscribedWithRecipients()))
            <a href="{!!  URL::route('projects.invitations.index',$project->id)  !!}" class="btn btn-primary btn-sm">Invitations</a>
        @endif
        @if($accountType == 'Sponsor')
            {!! Form::button('Withdraw',
                array('class' => 'btn btn-primary btn-sm btn-withdraw',
                    'data-toggle' => 'modal',
                    'data-target' => '#suspendModal',
                    'URL' => route('projects.withdraw', ['id' => $project->id])
                    )) !!}
        @endif
        </td>
    </tr>
    @endforeach
    </tbody>
    {!! Form::token() !!}
</table>

@include('projects.suspend_modal')