<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Change Project Details';
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
            {!! Form::open(array('route' => array('project.update', $project->id), '_method' => 'POST', 'files' => false)) !!}

                @include('inputgroups.project_detail')

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-primary btn-block" type="submit">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection