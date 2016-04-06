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
            <form method="POST" action="/password/reset">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">

                @if (count($errors) > 0)
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class='text-danger'>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="col-xs-12 col-md-6 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'email', 'label' => 'Email :']) )
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'password', 'type' => 'password', 'label' => 'Password :']) )
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'password_confirmation', 'type' => 'password', 'label' => 'Confirm Password :']) )
                </div>

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-primary pull-left" type="submit">Reset Password</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection