<!--<div class="infos col-xs-12">-->
    <h1 class="col-xs-8 center">Members Login</h1>
    {!! Form::open(['route'=>'login.action', 'class' => 'col-xs-12']) !!}
    <div class="row">
        {!! Form::label('username','Username : ', ['class' => 'col-xs-5 text-right']) !!}
        {!! Form::text('username', Input::old('username')) !!}
    </div>
    <div class="row">
        {!! Form::label('password','Password : ', ['class' => 'col-xs-5 text-right']) !!}
        {!! Form::password('password', Input::old('password')) !!}
    </div>
    <div class="row text-center">
        {!! Form::submit('Login',['class' => 'btn btn-primary btn-sm topGap']) !!}
        {!! Form::close() !!}
    </div>
<!--</div>-->