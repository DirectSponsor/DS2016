@extends('layouts.base_admin')
@section('content')
<div class="container col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-3">
    <h1> You are not authorised for this action ! </h1>
    <h3 class="error text-danger">{{ $exceptionMessage }}</h3>
    <cite class="error text-info">Check your permissions with the Project Coordinator!</cite>
</div>
@endsection
