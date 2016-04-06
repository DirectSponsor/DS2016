<!--
  This file is part of DirectSponsor Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<tr>
    <td></td> <!-- Checkbox Column -->
    <td></td> <!-- Expand Collapse Column -->

    <td>{{ $recipient->userRole->user->name }}</td>
    <td>{{ $recipient->userRole->user->email }}</td>
    <td>{{ $recipient->userRole->user->skrill_acc }}</td>
    <td>{{ $recipient->receiptsConfirmed()->max('due_date') ? $recipient->receiptsConfirmed()->max('due_date')->format("d/m/Y") : 'None' }}</td>

</tr>