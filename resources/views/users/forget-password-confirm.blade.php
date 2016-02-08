<h1 class="lead text-center">Forget Password - Set New Password</h1>
{!! Form::open(['route'=>'users.forgetPasswordConfirmAction']) !!}
{!! Form::hidden('token', $token) !!}
<div class="row text-center">
    {!! Form::label('email','Email : ', ['class' => 'text-right col-xs-4']) !!}
    {!! Form::text('email', Input::old('email'), ['class' => 'col-xs-8']) !!}
</div>
@if($errors->has('email')) {!!  $errors->first('email','<div class="row"><p class="text-danger"> :message </p></div>')  !!} @endif
<div class="row text-center">
    {!! Form::label('password','Password : ', ['class' => 'text-right col-xs-4']) !!}
    {!! Form::password('password', ['class' => 'col-xs-8']) !!}
</div>
@if($errors->has('password')) {!!  $errors->first('password','<div class="row"><p class="text-danger"> :message </p></div>')  !!} @endif
<div class="row text-center">
    {!! Form::label('password_confirmation','Confirm Password : ', ['class' => 'text-right col-xs-4']) !!}
    {!! Form::password('password_confirmation', ['class' => 'col-xs-8']) !!}
</div>
@if($errors->has('password_confirmation')) {!!  $errors->first('password_confirmation','<div class="row"><p class="text-danger"> :message </p></div>')  !!} @endif
<div class="row text-center">
    {!! Form::submit('Update password',['class' => 'btn btn-primary btn-sm topGap']) !!}
    {!! Form::close() !!}
</div>
<a href="{!!  URL::route('login.form')  !!}" class="add_item">Back to Login</a>