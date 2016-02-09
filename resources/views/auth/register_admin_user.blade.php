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
    <div class='col-xs-12 col-md-6 col-md-offset-3'>
        <form method="POST" action="/cb/regadmincomplete" _method='PUT'>
            {!! csrf_field() !!}
            {{ method_field('PUT') }}
            <input type="hidden" name="encryptedString" value="{{ $encryptedString }}">

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'name', 'label' => 'Name :']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'email', 'label' => 'Email :']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'password', 'label' => 'Password :', 'type' => 'password']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'password_confirmation', 'label' => 'Confirm Password :', 'type' => 'password']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    <button class="btn btn-success" type="submit">Register</button>
                </div>
            </div>

        </form>
    </div>
@endsection