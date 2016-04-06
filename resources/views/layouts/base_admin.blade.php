<!DOCTYPE html>
<!--
    This file is part of the DirectSponsor Application

    @copyright Copyright (c) 2016 McGarryIT
    @link      (http://www.mcgarryit.com)
-->
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/libraries/dataTables/DataTables-1.10.10/css/jquery.dataTables.css"/>
        <link rel="stylesheet" type="text/css" href="/libraries/dataTables/DataTables-1.10.10/css/dataTables.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="/libraries/dataTables/Responsive-2.0.0/css/responsive.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="/libraries/dataTables/Select-1.1.0/css/select.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="/libraries/dataTables/Buttons-1.1.0/css/buttons.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="/libraries/bootstrap/bootstrap-select-1.9.4/css/bootstrap-select.css"/>
        <link rel="stylesheet" type="text/css" href="/libraries/bootstrap/Bootstrap-3.3.5/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="/libraries/bootstrap/Bootstrap-3.3.5/css/bootstrap-theme.css"/>

        <link rel="stylesheet" type="text/css" href="/css/public_base.css"/>
        @yield('page_css')

        <script type="text/javascript" src="/libraries/jQuery-2.1.4/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="/libraries/bootstrap/Bootstrap-3.3.5/js/bootstrap.js"></script>
        <script type="text/javascript" src="https://datatables.net/download/build/nightly/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="/libraries/dataTables/DataTables-1.10.10/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" src="/libraries/dataTables/Responsive-2.0.0/js/dataTables.responsive.js"></script>
        <script type="text/javascript" src="/libraries/dataTables/Responsive-2.0.0/js/responsive.bootstrap.js"></script>
        <script type="text/javascript" src="/libraries/dataTables/Select-1.1.0/js/dataTables.select.js"></script>
        <script type="text/javascript" src="/libraries/dataTables/Buttons-1.1.0/js/dataTables.buttons.js"></script>
        <script type="text/javascript" src="/libraries/dataTables/Buttons-1.1.0/js/buttons.bootstrap.js"></script>
        <script type="text/javascript" src="/libraries/bootstrap/bootstrap-select-1.9.4/js/bootstrap-select.js"></script>

        <script type="application/javascript" src="/js/admin_common.js"></script>
        @yield('page_js')

        <!--[if IE]>
        <style>
        </style>
        <![endif]-->
    </head>
    <body class="bg-warning">
        @section('menu')
            <nav id="navbar_main" class="navbar navbar-default navbar-fixed-top col-md-12 clearfix">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button id="mobilemenu" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                    <a class="navbar-brand" href='/'><img class="img-responsive" src="/images/logo.png"/></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav navbar-right">
                    @if(Auth::user() and ((Auth::user()->isAdministrator()) or (Auth::user()->isCoordinator())))
                        <li class="dropdown horizontal">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Options<span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li class="">
                                {!! HTML::link('/invitations', 'Invitations') !!}
                            </li>
                            <li class="">
                                {!! HTML::link('/auth/logout', 'Email Templates') !!}
                            </li>
                            <li class="">
                                {!! HTML::link('/auth/logout', 'Language') !!}
                            </li>
                          </ul>
                        </li>
                    @endif
                    @if(Auth::user())
                        <li class="horizontal">
                            {!! HTML::link('/user/show', 'Email / Password') !!}
                        </li>
                        <li class="horizontal">
                            {!! HTML::link('/auth/logout', 'Logout') !!}
                        </li>
                    @endif
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
        @show

        <div id="page_container" class="container-fluid center col-xs-12">

            <div class="container-fluid center text-center marginBot">
                <div class="col-xs-offset-0 col-sm-6 col-sm-offset-3">
                    <p class="lead text-muted"><strong>Accounts : Direct Sponsor</strong></p>
                </div>
                @if(Auth::user())
                    <?php $requestSegs = Request::segments(); ?>
                    @if((count($requestSegs) > 0) and ($requestSegs[0] != 'projects'))
                        <span class='text-info'>Go back to:&nbsp;<a class="text-success" href="{{route('projects')}}">Project List</a></span>
                    @endif
                    @section('breadcrumb')
                    @show
                @endif
            </div>

            @section('content')
            <div class="container-fluid center col-xs-12">
                <div class="container">
                    <div class="wrapper col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-3 clearfix">
                    @if(Session::has('error'))
                        <p class="text-danger">{!!  Session::get('error')  !!}</p>
                    @endif
                    @if(isset($errors) && (count($errors) > 0))
                        <p class="text-danger">See error messages below</p>
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
                    <div class="col-xs-12 col-sm-3"></div>
                </div>
            @show
            </div>

            @section('footer')
            <div class='container-fluid center text-center'>
                <p><strong><small>&copy; DirectSponsor.org 2016</small></strong></p>
            </div>
            @show
        </div>

    </body>
</html>
