{!!
    Form::open( array('route'=>array('users.updateDetails',$id), 'method'=>'put'))
    !!}

@include('users.input_fields')

<div class='row center'>
    {!!
        Form::submit('Save Changes', array('class' => 'btn btn-primary btn-xs pull-left topGap')),
        Form::close()
        !!}
</div>

{!! Form::button('Change Password',
    array('class' => 'btn btn-primary btn-sm pull-right topGap',
        'data-toggle' => 'modal',
        'data-target' => '#changepasswordmodal',
        'URL' => route('users.updatePass', ['id' => $id])
        )) !!}

{!! Form::token() !!}
@include('users.password_modal')