<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $pageTitle = 'Amend Product';
 ?>
@extends('layouts.base_admin')

@section('title', 'Admin - OrganicSales')

@section('breadcrumb')
    <span class="text-success">&nbsp;&GT;&nbsp;
        {!! HTML::linkRoute('producer.edit', $producerName, array($producerId), array("class" => "text-success" )) !!}
    </span>
    <span class="text-success">&nbsp;&GT;&nbsp;
        {!! HTML::linkRoute('product.adminlist', 'Product List', array($producerId), array("class" => "text-success" )) !!}
    </span>
@endsection

@section('content')
    @parent

    <div class="row">
        <div class='col-xs-12 col-md-9'>
            {!! Form::open(array('route' => array('product.update', $product->id), '_method' => 'PUT', 'files' => true)) !!}
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                @include('inputgroups.product_detail')

                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 form-group">
                        <button class="btn btn-success pull-left" type="submit">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection