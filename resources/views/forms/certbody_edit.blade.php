<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Update Certification Body Details';
 ?>
@extends('layouts.base_admin')

@section('title', 'Admin - OrganicSales')

@section('page_css')
    <link rel="stylesheet" type="text/css" href="/libraries/jQueryUI/jquery-ui-1.11.4.custom/jquery-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/libraries/jQueryUI/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css"/>
@endsection

@section('page_js')
    <script type="text/javascript" src="/libraries/jQueryUI/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/certbody_form.js"></script>
@endsection

@section('breadcrumb')
    <span class="text-success">&nbsp;&GT;&nbsp;
        {!! HTML::linkRoute('cblist', 'Certfication Body List', array(), array("class" => "text-success" )) !!}
    </span>
@endsection

@section('content')
    @parent

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Certification Body Launch Data</h3>
            </div>
            <div class="panel-body">
                <div class='col-xs-12 col-md-12'>
                    {!! Form::open(array('route' => array('cb.update', $certbody->id), '_method' => 'PUT', 'class' => 'form-xxxxxx')) !!}
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        @include('inputgroups.certbody_edit')

                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-8 form-group">
                                <button class="btn btn-primary pull-left" type="submit">Save</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Manage Producers</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-md-12 form-group bg-success text-primary">
                    @include('elements.label', ['label' => 'Producers Summary :', 'classlabel' => 'col-disable'])
                    <?php $summary = $certbody->producerSummaryStatus(); ?>
                    <br>
                    <span class="col-xs-12 col-md-4">Pre-registered (Licence Numbers):&nbsp;<strong>{{ $summary['total'] }}</strong></span>
                    <span class="col-xs-12 col-md-4">Registered:&nbsp;<strong>{{ $summary['registered'] }}</strong></span>
                    <span class="col-xs-12 col-md-4">Approved:&nbsp;<strong>{{ $summary['approved'] }}</strong></span>
                    <br>&nbsp;
                </div>

                <div class='col-xs-12 col-md-6'>
                    {!! Form::open(array('route' => array('cb.addproducer', $certbody->id), '_method' => 'PUT', 'class' => 'form-xxxxxx')) !!}
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        <div class="col-xs-12 form-group">
                            @include('elements.label', ['label' => 'Add a New Producer Licence Number', 'classlabel' => 'col-disable'])
                        </div>
                        <div class="col-xs-12 form-group">
                            @include('elements.input', element::inputDefaults(['value' => old('licence_no'), 'name' => 'licence_no', 'label' => $certbody->ocb_code, 'class' => 'col-md-3']) )
                        </div>
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-primary text-break" type="submit">Add Producer Licence Number</button>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class='col-xs-12 col-md-6'>
                    {!! Form::open(array('route' => array('cb.addproducerfile', $certbody->id), '_method' => 'PUT', 'files' => true)) !!}
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        <div class="col-xs-12 form-group">
                            @include('elements.label', ['label' => 'Add File of Producer Licence Numbers', 'classlabel' => 'col-disable'])
                        </div>
                        <div class="col-xs-12 form-group">
                            {!! Form::label('Select Text (csv) File :') !!}
                            {!! Form::file('licencenumbers', null) !!}
                            @if($errors->has('licencenumbers')) {!!  $errors->first('licencenumbers','<p class="text-danger"> :message </p>')  !!} @endif
                        </div>
                         <div class="col-xs-12 form-group">
                            <button class="btn btn-primary" type="submit">Upload File</button>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-xs-12 col-md-6 form-group">

                    @include('elements.label', ['label' => 'Registration Email for Producers', 'classlabel' => 'col-disable'])

                    <br>
                    {!! HTML::mailto($mailToLink, 'Click this link to create a skeleton email for Producer Registration') !!}
                    <br><br>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Administrative Users</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-md-6 form-group">
                    @include('elements.label', ['label' => 'Admin Users for this body :', 'classlabel' => 'col-disable'])

                    @foreach($certbody->certAdminUsers as $user)
                    <p class='col-xs-12'>{{ $user->name }} </p>
                    @endforeach
                </div>

                <div class='col-xs-12 col-md-6'>
                    {!! Form::open(array('route' => array('cb.addadmin', $certbody->id), '_method' => 'PUT', 'class' => 'form-xxxxxx')) !!}
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        <div class="col-xs-12 form-group">
                            @include('elements.label', ['label' => 'Add a New Administrator User', 'classlabel' => 'col-disable'])
                        </div>
                        <div class="col-xs-12 form-group">
                            @include('elements.input', element::inputDefaults(['value' => old('email'), 'name' => 'email', 'label' => 'Email :', 'class' => 'col-xs-8 col-md-6']) )
                        </div>
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-primary" type="submit">Add Admin User</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection