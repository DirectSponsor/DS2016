<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('layouts.base_admin')

@section('content')
    <div class="container-fluid text-center">
        <h1>Welcome to <strong>Organic Food Sales Ireland</strong></h1>
    </div>
    <div class="container-fluid">
        <form method="POST" 
              @if(Request::is('*sponsor*'))
                action="/register/sponsor"
              @else
                action="/register/member"
              @endif
                >
            {!! csrf_field() !!}
            <input type="hidden" name="encryptedString" value="{{ $encryptedString }}">

            <div class="col-xs-12">
                @include('elements.input', element::inputDefaults(['value' => old('name', null),
                    'name' => 'name', 'label' => 'Name :', 'type' => 'text',
                    'class' => 'col-xs-6 col-md-2 left', 'classlabel' => 'col-xs-6 col-md-4 right text-right']))
            </div>

            <div class="col-xs-12">
                @include('elements.input', element::inputDefaults(['value' => old('email', null),
                    'name' => 'email', 'label' => 'Email :', 'type' => 'email',
                    'class' => 'col-xs-6 col-md-2 left', 'classlabel' => 'col-xs-6 col-md-4 right text-right']))
            </div>

            <div class="col-xs-12">
                @include('elements.input', element::inputDefaults(['value' => old('skrill_acc', null),
                    'name' => 'skrill_acc', 'label' => 'Skrill Account :', 'type' => 'email',
                    'class' => 'col-xs-6 col-md-2', 'classlabel' => 'col-xs-6 col-md-4 right text-right']))
            </div>

            <div class="col-xs-12">
                @include('elements.input', element::inputDefaults(['value' => old('password', null),
                    'name' => 'password', 'label' => 'Password :', 'type' => 'password',
                    'class' => 'col-xs-6 col-md-2', 'classlabel' => 'col-xs-6 col-md-4 right text-right']))
            </div>

            <div class="col-xs-12">
                @include('elements.input', element::inputDefaults(['value' => old('password_confirmation', null),
                    'name' => 'password_confirmation', 'label' => 'Confirm Password :', 'type' => 'password',
                    'class' => 'col-xs-6 col-md-2', 'classlabel' => 'col-xs-6 col-md-4 right text-right']))
            </div>

            <div class="col-xs-6 col-md-4 right text-right">
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
        </form>
    </div>
@endsection