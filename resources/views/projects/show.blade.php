<?php
    $accountType = Auth::user()->account_type;
    $strippedProjectDesc = strip_tags($project->content);
?>

<div class="clearfix">
    <h5 class="col-xs-12 col-md-3 botGap">
        Project Information
        <span id="project-info-icon" class="col-xs-3 col-md-1 pull-right pointer glyphicon glyphicon-plus-sign" data-toggle="collapse" data-target="#project-info"></span>
    </h5>
</div>

<div id="project-info" class="collapse">
    @include('projects.info')
    @if($accountType == 'Admin')
        <div class='row center'>
        {!!
            Form::open(array('class'=>'inline', 'method'=>'get','route'=>array('projects.edit',$project->url))),
            Form::submit('Edit Project', array('class' => 'btn btn-primary btn-xs pull-right botGap topGap')),
            Form::close()
            !!}
        </div>
    @endif
</div>

@if($accountType == 'Recipient')
<div class="panel panel-default">
  <div class="panel-body">
      <h4>Recipient Information:</h4>
    @include('recipients.info')
  </div>
</div>
@endif


<?php // Payments showen only for Admin ?>
@if($accountType == 'Admin')

    <h2>Payments: </h2><?php $payments = $project->payments; $profileAccountType = 'Admin'; ?>
        @include('payments.index')

    <h2>Recipients: </h2><?php $recipients = $project->recipients; ?>
        @include('recipients.index')

    <h2>Sponsors: </h2><?php $sponsors = $project->sponsors; ?>
        @include('sponsors.index')

@endif

<div class="panel panel-default">
  <div class="panel-body">
      <h4>Project Activities: </h4>
        <?php $spends = $project->spends; ?>
        @include('spends.index')
  </div>
</div>