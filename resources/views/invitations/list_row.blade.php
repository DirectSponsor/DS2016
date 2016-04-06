<!--
  This file is part of DirectSponsor Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <?php
    $invitationUser = $user::where('email', $invitation->email)->first();
 ?>
<tr>
    <td></td> <!-- Checkbox Column -->
    <td></td> <!-- Expand Collapse Column -->
    <td>{{ $project->id }}</td>
    <td>{{ $invitation->id }}</td>
    <td>{{ $invitation->created_at }}</td>
    <td>{{ $invitation->email }}</td>
    <td>{{ $invitation->role_type }}</td>
    <td>{{ isset($invitationUser) ? 'Yes' : 'No' }}</td>
    <td>{{ isset($invitationUser) ? $invitationUser->created_at : 'n/a' }}</td>
</tr>