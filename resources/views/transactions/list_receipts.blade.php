<!--
  This file is part of DirectSponsor Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('layouts.base_admin')

@section('title', 'Accounts - DirectSponsor')

@section('page_js')
    <script type="application/javascript" src="/js/receipts_list.js"></script>
    <script>
        <?php
            echo "var enableSupport={$enableSupport};";
            if (Auth::user()->isSponsor()) {
                echo "var isSponsor=1;";
            } else {
                echo "var isSponsor=0;";
            }
            echo "var token='".csrf_token()."';";
        ?>
    </script>
@endsection

@section('content')
    @parent

<div class="panel panel-default clearfix">
    <div class="panel-heading">
        <h3 class="panel-title">Receipts List for : <strong class='text-primary'>{{ $project->name }}</strong></h3>
    </div>
    <div class="panel-body">
        @if((Auth::user()->isAdministrator()) || (Auth::user()->isCoordinator()))
        <div class='container-fluid text-center'>
             {!! HTML::link('/transaction/create/receipt', 'Add Ad-hoc Group Fund Receipt') !!}
        </div>
        @endif
        <div class="container-fluid">
            <table id='receipts_list' class='display table-responsive table-bordered table-striped'>
                <thead>
                    <tr>
                        <th></th> <!-- Expand Collapse Column -->
                        <th>Select</th> <!--  Checkbox Column -->
                        <th class="never">Trans ID</th>
                        <th class="all">Month<br>Due</th>
                        <th class="all">{{ $project->local_currency_symbol }}</th> <!-- Local Currency Amount -->
                        <th class="all">€</th> <!-- Euro Currency Amount -->
                        <th>Status</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Description</th>
                        <th>Updated</th>
                        <th class="desktop">Date<br>Due</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($receipts as $receipt)
                    @include('transactions.list_receipt_row')
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection