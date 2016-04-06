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
    <script type="application/javascript" src="/js/invitation_list.js"></script>
    <script>
        var projects = {};
    </script>
@endsection

@section('content')
    @parent

    @foreach($projects as $project)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Invitations (Coordinator, Recipients) for : <strong class='text-primary'>{{ $project->name }}</strong></h3>
                @if($project->isFullySupported())
                    <script>
                        projects['<?php echo $project->id . "'] = 1;" ; ?>
                    </script>
                @else
                    <script>
                        projects['<?php echo $project->id . "'] = 0;" ; ?>
                    </script>
                <br>
                @include('forms.invitation_create')
                @endif
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                    <table id='invitation_list<?php echo $project->id; ?>' class='display table-responsive table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th></th> <!-- Expand Collapse Column -->
                                <th>Select</th> <!--  Checkbox Column -->
                                <th class="never">Project ID</th>
                                <th class="never">Invitation ID</th>
                                <th class="all">Date Sent</th>
                                <th class="all">Email Address</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($project->invitations as $invitation)
                            @include('invitations.list_row')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@endsection