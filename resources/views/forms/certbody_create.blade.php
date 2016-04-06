<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Add New Cert Body';
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
                <h3 class="panel-title">Certification Body Information</h3>
            </div>
            <div class="panel-body">
                <div class='col-xs-12 col-md-12'>
                    {!! Form::open(array('route' => array('cb.store'), '_method' => 'PUT', 'class' => 'form-xxxxxx')) !!}
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        @include('inputgroups.certbody_add')

                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 form-group">
                                <button class="btn btn-primary pull-left" type="submit">Save</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection