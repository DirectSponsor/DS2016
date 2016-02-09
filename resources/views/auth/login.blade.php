<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('default.welcome')

@section('content')
    <div class="container-fluid col-xs-12 left text-center">
        <h1>Welcome to <strong>Organic Food Sales Ireland</strong></h1>
    </div>
    <div class="row">
        <div class='col-xs-12 col-md-6 col-md-offset-3'>
            <form method="POST" action="/auth/login">
                {!! csrf_field() !!}

                @include('inputgroups.login_fields')

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-success pull-left" type="submit">Login</button>
                    </div>
                </div>

            </form>
            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    {!! HTML::link('/password/email', 'Forgotten Password?') !!}
                </div>
            </div>
        </div>
    </div>
@endsection