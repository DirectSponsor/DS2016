<h1 class="lead text-center">Forget Password</h1>
{!! Form::open(['route'=>'users.forgetPasswordAction']) !!}
<div class="row text-center">
    {!! Form::label('email','Email : ', ['class' => 'text-right col-xs-4']) !!}
    {!! Form::text('email', Input::old('email'), ['class' => 'col-xs-8']) !!}
</div>
@if($errors->has('email')) {!!  $errors->first('email','<div class="row"><p class="text-danger"> :message </p></div>')  !!} @endif
<div class="row text-center">
    {!! Form::submit('Send confirmation link',['class' => 'btn btn-primary btn-sm topGap']) !!}
    {!! Form::close() !!}
</div>
<a href="{!!  URL::route('login.form')  !!}" class="add_item">Back to Login</a>