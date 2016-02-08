<!doctype html>
<html>
    <head>
        <title>Direct Sponsor</title>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Style -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.8/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="{{ URL::asset('css/site.css') }}" />

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.8/js/dataTables.bootstrap.min.js"></script>

        <script type="text/javascript" src="{{ URL::asset('js/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/common_functions.js') }}"></script>
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
            <div id="content" class="container-fluid center">
                @if(isset($error))
                    <p class="text-danger">{!!  $error  !!}</p>
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
                {!! $content !!}
            </div>
            <div class="row">
                <a href="{!!  URL::route('users.forgetPasswordForm')  !!}" class="col-xs-6 text-left">Forgot your password? Reset here</a>
            </div>
            <div class="row">
                <a href="{!!  URL::route('users.resendConfEmailForm')  !!}" class="col-xs-6 text-left">Or resend the confirmation email</a>
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