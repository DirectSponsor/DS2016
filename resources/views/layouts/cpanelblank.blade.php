<?php
    $env = app()->env;
    $version = $app::VERSION
    ?>
<!doctype html>
<html>
    <head>
        <title> Control Panel</title>
        <meta charset='utf-8'>
        <!-- Style -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Style -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,sc-1.3.0,se-1.0.0/datatables.min.css"/>
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.8/css/dataTables.bootstrap.min.css">-->
        <link rel="stylesheet" href="{{ URL::asset('css/site.css') }}" />



        <!-- Latest compiled and minified JavaScript -->
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,sc-1.3.0,se-1.0.0/datatables.min.js"></script>
<!--        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.8/js/dataTables.bootstrap.min.js"></script>-->

        <script type="text/javascript" src="{{ URL::asset('js/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common_functions.js') }}"></script>
    </head>
    <body>
        <div id="page" class="container-fluid">
            <div id="header">
                <fieldset>
                    <div class="inner">
                        <a class='logo' href="/">{!!  HTML::image('images/logo.png','Direct Sponsor');  !!}</a>
                </div>
                </fieldset>
            </div>
            <div id="content" class="container-fluid col-xs-12">
                <div class="inner">
                    <a class='error' href="/" title="Home">Home</a>
                    @yield('content')
                </div>
            </div>
            <div id="footer" class="container-fluid col-xs-12">
                <hr/>
                <div class="inner text-center col-xs-12">
                Directsponsor &copy; 2015
                </div>
            </div>
        </div>
    </body>
</html>
