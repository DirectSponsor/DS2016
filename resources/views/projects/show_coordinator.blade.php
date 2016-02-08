<?php
    $accountType = Auth::user()->account_type;
    $strippedProjectDesc = strip_tags($project->content);
?>

<div class="clearfix">
    <span id="project-info-icon" class="vertical-middle pointer glyphicon glyphicon-plus-sign" data-toggle="collapse" data-target="#project-info"></span>
    <p id="project-info-collapse-text" class="col-xs-10 col-md-2 text-warning">
        Show Project Detail
    </p>
</div>

<div id="project-info" class="collapse">
    @include('projects.info')
</div>

<div class="panel panel-default">
  <div class="panel-body">
      <h4>Project Activities: </h4>
        <?php $spends = $project->spends; ?>
        @include('spends.index')
  </div>
</div>