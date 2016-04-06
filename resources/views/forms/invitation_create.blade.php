<div class='row'>
    {!! Form::open(array('route' => array('invitation.store', $project->id), '_method' => 'PUT', 'files' => false)) !!}
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        @include('inputgroups.invitation_detail')

        <div class="col-xs-11 col-xs-offset-1 col-sm-3 col-sm-offset-0 pull-left">
            <button id="sendInvitation" class="btn btn-primary pull-left" type="submit">Send Invitation</button>
        </div>
    {!! Form::close() !!}
</div>