<!--
  This file is part of DirectSponsor Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<tr>
    <td></td> <!-- Checkbox Column -->
    <td></td> <!-- Expand Collapse Column -->

    <td>{{ $sponsor->userRole->user->name }}</td>
    <td>{{ $sponsor->userRole->user->email }}</td>
    <td>{{ $sponsor->userRole->user->skrill_acc }}</td>
    <td>{{ $sponsor->paymentsConfirmed()->max('due_date') ? $sponsor->paymentsConfirmed()->max('due_date')->format("d/m/Y") : 'None' }}</td>
</tr>