<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Edit Sub-category';
 ?>
@extends('layouts.base_admin')

@section('title', 'Admin - OrganicSales')

@section('page_css')
@endsection

@section('page_js')
    <!--<script type="text/javascript" src="/js/certbody_form.js"></script>-->
@endsection

@section('breadcrumb')
    <span class="text-success">&nbsp;&GT;&nbsp;
        {!! HTML::linkRoute('subcatglist', 'Sub-category List', array(), array("class" => "text-success" )) !!}
    </span>
@endsection

@section('content')
    @parent

    <div class="row">
        <div class='col-xs-12 col-md-12'>
            {!! Form::open(array('route' => array('subcatg.update', $subCategory->id), '_method' => 'PUT', 'class' => 'form-xxxxxx')) !!}
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                @include('inputgroups.subCategory_detail')

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-success pull-left" type="submit">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection