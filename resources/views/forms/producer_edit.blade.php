<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Producer Profile Data';
 ?>
@extends('layouts.base_admin')

@section('title', 'Admin - OrganicSales')

@section('content')
    @parent
            <div class="row">
                <div class="col-xs-10 col-md-5">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add, Edit or Delete</h3>
                        </div>
                        <div class="panel-body">
                                {!! HTML::linkRoute('product.adminlist', 'Products', array($producer->id),
                                    array('class' => 'btn btn-info btn-xs btn-sm pull-left col-xs-8 col-md-5 col-xs-offset-1', 'role' => 'button')) !!}
                                {!! HTML::linkRoute('distributor.adminlist', 'Distributors', array($producer->id),
                                    array('class' => 'btn btn-info btn-xs btn-sm pull-left col-xs-8 col-md-5 col-xs-offset-1', 'role' => 'button')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            {!! Form::open(array('route' => array('producer.update', $producer->id), '_method' => 'PUT', 'class' => 'form-xxxxxx')) !!}
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                @include('inputgroups.producer_detail')

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-primary pull-left" type="submit">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}
            </div>
@endsection