<!--
  This file is part of DirectSponsor Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('layouts.base_admin')

@section('title', 'Accounts - DirectSponsor')

@section('page_js')
    <script type="application/javascript" src="/js/project_list.js"></script>
    <script>
        <?php
            echo "var enableSupport={$enableSupport};";
            if (Auth::user()->isSponsor()) {
                echo "var isSponsor=1;";
            } else {
                echo "var isSponsor=0;";
            }
        ?>
    </script>
@endsection

@section('content')
    @parent

<div class="panel panel-default clearfix">
    <div class="panel-heading">
        <h3 class="panel-title">Project List</h3>
    </div>
    <div class="panel-body">
        @if(Auth::user()->isAdministrator())
        <div class='container-fluid text-center'>
             {!! HTML::link('/projects/create', 'Add New Project') !!}
        </div>
        @endif
        <div class="container-fluid">
            <table id='project_list' class='display table-responsive table-bordered table-striped'>
                <thead>
                    <tr>
                        <th></th> <!-- Expand Collapse Column -->
                        <th>Select</th> <!--  Checkbox Column -->
                        <th class="never">projectid</th>
                        <th class="all">Project</th>
                        <th>Pending<br>Trans</th>
                        @if(Auth::user()->isSponsor())
                        <th>Member</th>
                        @endif
                        <th>Fully<br>Supported</th>
                        <th>Last Receipt</th>
                        <th>Receipts<br>Total</th>
                        <th>Spending<br>Total</th>
                        <th>Coordinator</th>
                        <th>Recipients</th>
                        <th>Sponsors</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($projects as $project)
                    @include('projects.list_row')
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection