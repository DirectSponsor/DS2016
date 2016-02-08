<!DOCTYPE html>
<!--
    This file is part of the Organic Directory Application

    @copyright Copyright (c) 2016 McGarryIT
    @link      (http://www.mcgarryit.com)
-->
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,sc-1.3.0,se-1.0.0/datatables.min.css"/>
<!--        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css"/>-->
        <link rel="stylesheet" type="text/css" href="/css/site_base.css"/>
        @yield('page_css')
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,sc-1.3.0,se-1.0.0/datatables.min.js"></script>
<!--        <script type="text/javascript" src="/js/bootstrap.min.js"></script>-->
        <script type="application/javascript" src="/js/common_functions.js"></script>
        @yield('page_js')
    </head>
    <body class="bg-success">
        @section('menu')
        <div class="navbar navbar-default navbar-fixed-top col-md-12 clearfix">
            <div class="container-fluid col-xs-6 col-md-3">
                <a class='logo img-responsive' href="/">{!!  HTML::image('images/logo.png','Direct Sponsor');  !!}</a>
                @if($env != 'production')
                    <span class='btn btn-primary'>
                        Env: {!!  $env  !!} Laravel Vers: {!!  $version  !!}</span>
                @endif
            </div>
            <div class="container-fluid col-xs-6 col-md-2 pull-right">
                @include('layouts.menu')
            </div>
        </div>
        @show

        <div id="page_container" class="container-fluid center col-xs-12 col-md-10">

            <div class="container-fluid center text-center">
                <h1 class="left">Accounts System</h1>
                    <?php $requestSegs = Request::segments(); ?>
                    @if($requestSegs[0] != 'admin')
                        <span class='text-info'>Go back to:&nbsp;<a class="text-success" href="{{route('admin')}}">Producer List</a></span>
                    @endif
                    @section('breadcrumb')
                    @show
            </div>

            @section('content')
            <div class="container-fluid center col-xs-12 col-md-10">
                @if(isset($pageTitle))
                <div class="row">
                    <p class="lead text-info">{!! $pageTitle or 'Page Title Not Set' !!}</p>
                </div>
                @endif
                <div class="row">
                @if(Session::has('error'))
                    <p class="text-danger">{!!  Session::get('error')  !!}</p>
                @endif
                @if(Session::has('success'))
                    <p class="text-danger">{!!  Session::get('success')  !!}</p>
                @endif
                @if(Session::has('info'))
                    <p class="text-info">{!!  Session::get('info')  !!}</p>
                @endif
                @if(Session::has('notification'))
                    <p class="text-warning">{!!  Session::get('notification')  !!}</p>
                @endif
                </div>
            @show
            </div>

            @section('footer')
            <div class='container-fluid center text-center'>
                <p><strong><small>&copy; DirectSponsor 2016</small></strong></p>
            </div>
            @show
        </div>

    </body>
</html>
