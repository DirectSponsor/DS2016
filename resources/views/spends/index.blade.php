<?php $accountType = Auth::user()->account_type; ?>
@if($accountType == 'Admin' || $accountType == 'Coordinator')
    <div class="row">
        <a href="{!!  URL::route('projects.spends.create',$project->id)  !!}" class="btn btn-primary btn-sm botGap"
           style="clear: both; float: left; margin-left: 30px;">New Activity</a>
    </div>
@endif
<table class="table data table-striped table-bordered">
    <thead><tr>
        <th>Date</th>
        <th>Coordinator</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Options</th>
    </tr></thead>
    <tbody>
    @if($spends->count() == 0)
    <tr>
        <td colspan="5"><p>There is no activities yet ! </p></td>
    </tr>
    @endif
    @foreach($spends as $spend)
    <tr>
        <td>{!! $spend->created_at !!}</td>
        <td>{!! $spend->coordinator()->user->username !!}</td>
        <td>{!! $spend->amount !!}</td>
        <td>{!! $spend->description !!}</td>
        <td>
            @if($accountType == 'Admin')
                {!!  Form::open(array('class'=>'inline', 'method'=>'delete','route' => array('projects.spends.destroy', $spend->project_id, $spend->id))),
                    Form::submit('Delete', array('class' => 'btn btn-primary btn-sm')),
                Form::close()  !!}
            @endif
        </td>
    </tr>
    @endforeach
</tbody></table>