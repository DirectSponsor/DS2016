<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Add New Project';
 ?>
@extends('layouts.base_admin')

@section('title', 'Project')

@section('page_js')
    <script type="application/javascript" src="/js/project_form.js"></script>
@endsection

@section('content')
    @parent

    <div class="row">
        <div class='col-xs-12'>
            {!! Form::open(array('route' => array('project.store'), '_method' => 'PUT', 'files' => true)) !!}
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                @include('inputgroups.project_detail')

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-primary pull-left" type="submit">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection