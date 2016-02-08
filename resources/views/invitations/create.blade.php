{!!
    Form::open(array('route'=>array('projects.invitations.store',$project_id))),
        Form::hidden('project_id', $project_id),
        Form::hidden('role_id', $role_id),
        Form::label('sent_to','Email :'), Form::text('sent_to',Input::old('sent_to'))
!!}
    @if($errors->has('sent_to')) {!!  $errors->first('sent_to','<p class="text-danger"> :message </p>')  !!} @endif
    <div class="clear"></div>
{!!
    Form::submit('Send invitation', array('class' => 'btn btn-primary btn-sm')),
    Form::close()
!!}