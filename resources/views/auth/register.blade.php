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
    <div class="container-fluid col-xs-8 col-xs-offset-4">
        <form method="POST" action="/auth/register">
            {!! csrf_field() !!}
            <input type="hidden" name="encryptedString" value="{{ $encryptedString }}">

            <div class="col-xs-12">
                <label class="col-xs-6 col-md-4 right text-right" for="name">Name</label>
                <input class="col-xs-6 col-md-2 left" type="text" name="name" value="{{ old('name') }}">
            </div>

            <div class="col-xs-12">
                <label class="col-xs-6 col-md-4 right text-right" for="email">Email</label>
                <input class="col-xs-6 col-md-2 left" type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="col-xs-12">
                <label class="col-xs-6 col-md-4 right text-right" for="password">Password</label>
                <input class="col-xs-6 col-md-2 left" type="password" name="password" id="password">
            </div>

            <div class="col-xs-12">
                <label class="col-xs-6 col-md-4 right text-right" for="password_confirmation">Confirm Password</label>
                <input class="col-xs-6 col-md-2 left" type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <div class="col-xs-6 col-md-4 right text-right">
                <button class="btn btn-success" type="submit">Register</button>
            </div>
        </form>
    </div>
@endsection