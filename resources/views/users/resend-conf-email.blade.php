<h1 class="lead text-center">Resend Confirmation Email</h1>
{!! Form::open(['route'=>'users.resendConfEmailAction']) !!}
<div class="row text-center">
    {!! Form::label('username','Email : ', ['class' => 'text-right col-xs-4']) !!}
    {!! Form::text('username', Input::old('username'), ['class' => 'col-xs-8']) !!}
</div>
@if($errors->has('username')) {!!  $errors->first('username','<div class="row"><p class="text-danger"> :message </p></div>')  !!} @endif
<div class="row text-center">
    {!! Form::submit('Send',['class' => 'btn btn-primary btn-sm topGap']) !!}
    {!! Form::close() !!}
</div>
<a href="{!!  URL::route('login.form')  !!}" class="add_item">Back to Login</a>