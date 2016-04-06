@extends('layouts.base_admin')
@section('content')
<div class="container col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-3">
    <h1>Apologies<br>Looks like we are having problems finding data<br>Data Not Found</h1>
    <h3 class="error text-danger">{{ $exceptionMessage }}</h3>
    <cite class="error text-info">Please inform Project Administrator or Coordinator!</cite>
</div>
@endsection
