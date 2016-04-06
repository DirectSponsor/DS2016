<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Support Project : Select Amount';
 ?>
@extends('layouts.base_admin')

@section('title', 'Project')

@section('page_js')
    <script type="application/javascript" src="/js/support_form.js"></script>
@endsection

@section('content')
    @parent

    <div class="row">
        <div class='col-xs-12'>
            {!! Form::open(array('route' => array('project.supportconfirm', $project->id), '_method' => 'POST', 'files' => false)) !!}

                @include('inputgroups.support_amount_detail')

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-primary btn-block" type="submit">Confirm Support</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection