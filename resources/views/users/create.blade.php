{!!
    Form::open( array('route'=>array('members.newUser',$project_id), 'method'=>'put'))
    !!}

@include('users.input_fields')

{!! Form::label('password','Password :', array('class' => 'col-xs-12 col-md-3')),
    Form::password('password', array('class' => 'col-xs-12 col-md-6'))
    !!}
    @if($errors->has('password')) {!!  $errors->first('password','<p class="text-danger"> :message </p>')  !!} @endif
{!! Form::label('password_confirmation','Password Confirmation :', array('class' => 'col-xs-12 col-md-3')),
    Form::password('password_confirmation', array('class' => 'col-xs-12 col-md-6'))
    !!}
    @if($errors->has('password_confirmation')) {!!  $errors->first('password_confirmation','<p class="text-danger"> :message </p>')  !!} @endif

<div class='row center'>
    {!!
        Form::submit('Save', array('class' => 'btn btn-primary btn-xs pull-left topGap')),
        Form::close()
        !!}
</div>

{!! Form::token() !!}
