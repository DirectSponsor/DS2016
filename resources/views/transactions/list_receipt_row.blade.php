<!--
  This file is part of DirectSponsor Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $projectMember = Auth::user()->getProjectMember($project->id);
    ?>

<tr>
    <td></td> <!-- Checkbox Column -->
    <td></td> <!-- Expand Collapse Column -->
    <td>{{ $receipt->id }}</td>
    <td>{{ $receipt->month }}</td>
    <td>{{ $receipt->local_amount }}</td>
    <td>{{ $receipt->euro_amount }}</td>
    <td>{{ $receipt->status }}</td>
    <td>{{ $receipt->sender->userRole->user->name }}</td>
    <td>{{ $receipt->projectMember->userRole->user->name }}</td>
    <td>{{ $receipt->description }}</td>
    <td>{{ $receipt->updated_at->format('Y-m-d') }}</td>
    <td>{{ $receipt->due_date->format('Y-m-d') }}</td>
</tr>