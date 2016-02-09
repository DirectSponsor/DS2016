<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('layouts.base_admin')

@section('page_js')
    <script type="application/javascript" src="/js/admin_common.js"></script>
@endsection

@section('content')
    @parent
    
    <div class="container-fluid col-xs-12 left text-center">
        <h1>Update your details</h1>
    </div>
    <div class='col-xs-12 col-md-6 col-md-offset-3'>
        <form method="POST" action="/user/update" _method='PUT'>
            {!! csrf_field() !!}
            {{ method_field('PUT') }}

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(
                    ['value' => old('name', $user->name), 'name' => 'name', 'label' => 'Name :']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => old('email', $user->email), 'name' => 'email', 'label' => 'Email :']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'current_password', 'label' => 'Current Password :', 'type' => 'password']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'new_password', 'label' => 'New Password :', 'type' => 'password']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'password_confirmation', 'label' => 'Confirm Password :', 'type' => 'password']) )
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-md-12 form-group">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </div>

        </form>
    </div>
@endsection