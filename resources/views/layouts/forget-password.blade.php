<!doctype html>
<html>
    <head>
        <title> Forget Password </title>
        <meta charset='utf-8'>
        <!-- Style -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,sc-1.3.0,se-1.0.0/datatables.min.css"/>
        <link rel="stylesheet" href="{{ URL::asset('css/site.css') }}" />
        <!-- Latest compiled and minified JavaScript -->
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,sc-1.3.0,se-1.0.0/datatables.min.js"></script>
    </head>
    <body>
        <div id="page" class="container-fluid col-xs-12 center">
            <div id="header" class="center">
                <fieldset>
                    <div class="inner col-xs-8 center">
                        <a class='center' href="/">{!!  HTML::image('images/logo.png','Direct Sponsor', ['class' => 'center']);  !!}</a>
                </div>
                </fieldset>
            </div>
            <div id="content" class="container-fluid col-xs-10 col-sm-6 center">
                @if(isset($error))
                    <p class="text-danger">{!!  $error  !!}</p>
                @endif
                @if(isset($status))
                    <p class="text-success">{!!  $status  !!}</p>
                @endif
                @if(isset($success))
                    <p class="text-success">{!!  $success  !!}</p>
                @endif
                @if(isset($info))
                    <p class="text-info">{!!  $info  !!}</p>
                @endif
                @if(isset($notification))
                    <p class="text-warning">{!!  $notification  !!}</p>
                @endif
                {!!  $content  !!}
            </div>
            <div id="footer" class="container-fluid col-xs-12 center">
                <hr/>
                <div class="inner text-center col-xs-12">
                Directsponsor &copy; 2015
                </div>
            </div>
        </div>
    </body>
</html>