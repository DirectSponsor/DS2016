<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('default.welcome')

@section('content')
<div class="container-fluid col-xs-12 left">
    <div class="col-xs-12">
        <p class="lead col-xs-3 col-md-4 right text-right" for="email">Send Invitation</p>
    </div>
    <div class='col-md-3'>

    </div>
    <div class='col-xs-10 col-md-9'>
        <form method="POST" action="/invitation/store">

            @include('inputgroups.invitation')

            <div class="row">
                <div class="col-md-6 form-group">
                    <button class="btn btn-success" type="submit">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection