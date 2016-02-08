{!! Form::hidden('original_url', $original_url) !!}
{!! Form::hidden('new_user_type', $newUserType) !!}
<div class='row'>
    {!!
        Form::label('username','Username :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('username',Input::old('username'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('username')) {!!  $errors->first('username','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('name','Full Name :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('name',Input::old('name'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('name')) {!!  $errors->first('name','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('email','Email :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('email',Input::old('email'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('email')) {!!  $errors->first('email','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('skrill_acc','Skrill Account :', array('class' => 'col-xs-12 col-md-2')),
        Form::text('skrill_acc', $skrill_acc, array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('skrill_acc')) {!!  $errors->first('skrill_acc','<p class="text-danger"> :message </p>')  !!} @endif
</div>
