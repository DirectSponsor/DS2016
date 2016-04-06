<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('default.welcome')

@section('content')
    @parent
    <div class="container">
        <div class='row col-xs-12 col-sm-6 col-sm-offset-3'>
            <form method="POST" action="/auth/login">
                {!! csrf_field() !!}

                @include('inputgroups.login_fields')

                <div class="row clearfix">
                    <div class="col-xs-12 form-group">
                        <button class="btn btn-primary pull-left" type="submit">Login</button>
                    </div>
                </div>

            </form>
            <div class="row clearfix">
                <div class="col-xs-12 form-group">
                    {!! HTML::link('/password/email', 'Forgotten Password?') !!}
                </div>
            </div>
        </div>
    </div>
@endsection