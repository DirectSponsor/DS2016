@extends('layouts.cpanelblank')
@section('content')
    <p class="error">NOT FOUND :: Apologies - Looks like we are having problems finding pages, or data</p>
    @if(isset($exceptionMessage))
        <p class="error">{!! $exceptionMessage !!}</p>
    @endif
@endsection
