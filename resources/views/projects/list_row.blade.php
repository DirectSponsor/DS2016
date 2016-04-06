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
    <td>{{ $project->id }}</td>
    <td>
        {!! HTML::linkRoute('project.edit', $project->name ." : ".$project->status, array($project->id)) !!}
    </td>
    <td>
        <?php
            $projectMember = Auth::user()->getProjectMember($project->id);
        ?>
            @if($projectMember)
                @if($projectMember->receiptsDue()->count() > 0)
                    {!! HTML::linkRoute('pendingreceipts', $projectMember->receiptsDue()->count().' for You',
                            array($project->id, $projectMember->id), array('class' => 'text-danger')) !!}
                @else
                    {{ $projectMember->receiptsDue()->count().' for You' }}
                @endif
            @else
                @if($project->getPaymentsDue()->count() > 0)
                    {!! HTML::linkRoute('pendingreceipts', $project->getPaymentsDue()->count().' for Project',
                            array($project->id), array('class' => 'text-info')) !!}
                @else
                    {{ $project->getPaymentsDue()->count().' for Project' }}
                @endif
            @endif
    </td>
    @if(Auth::user()->isSponsor())
    <td>
        @if($projectMember)
        <strong class="text-danger">Yes</strong>
        @else
        <strong class="text-info">No</strong>
        @endif
    </td>
    @endif
    <td>
        {{ $project->isFullySupported() ? 'Yes' : 'No' }}
    </td>
    <td>
        {{ $project->getPayments()->max('due_date') ? $project->getPayments()->max('due_date')->format("d/m/Y") : 'None' }}
    </td>
    <td>
        {{ $project->getPayments()->sum('euro_amount') }}
    </td>
    <td>
        {{ $project->getSpends()->sum('euro_amount') }}
    </td>
    <td>
        {{ $project->getCoordinator(true) ? $project->getCoordinator(true)->userRole->user->name : 'No Coordinator' }}
    </td>
    <td>
        {!! HTML::linkRoute('recipients.list', $project->getRecipients(true)->count(), array($project->id)) !!}
    </td>
    <td>
        {!! HTML::linkRoute('sponsors.list', $project->getSponsors(true)->count(), array($project->id)) !!}
    </td>
</tr>