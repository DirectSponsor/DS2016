<!--
  This file is part of DirectSponsor Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
@extends('layouts.base_admin')

<?php
   //$pageTitle = 'Project List';
?>

@section('title', 'Accounts - DirectSponsor')

@section('page_js')
    <script type="application/javascript" src="/js/sponsor_list.js"></script>
@endsection

@section('content')
    @parent

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Sponsor List for <strong>{{ $project->name }}</strong></h3>
    </div>
    <div class="panel-body">
        <div class="container-fluid">
            <table id='sponsor_list' class='display table-responsive table-bordered table-striped'>
                <thead>
                    <tr>
                        <th></th> <!-- Checkbox Column -->
                        <th></th> <!-- Expand Collapse Column -->
                        <th class="all">Name</th>
                        <th>Email</th>
                        <th>Skrill Acc</th>
                        <th>Last Payment</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($project->getSponsors() as $sponsor)
                    @include('members.sponsor_row')
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection