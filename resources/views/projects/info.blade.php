<div class="panel panel-default">
  <div class="panel-body">
    <h4>Project Information: </h4>
    <div class="infos">
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Namex :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! $project->name !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Coordinator UserName :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! $project->coordinator->user->username  !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Coordinator Email :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! $project->coordinator->user->email  !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Recipients Allowed :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! $project->max_recipients  !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Recipients Confirmed :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! $project->confirmedRecipients()  !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Sponsors Number :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! $project->sponsors->count()  !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Sponsors Registration Link :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! URL::route('sponsors.join',$project->url)  !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Amount :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!!  $project->amount  !!} in {!!  $project->currency  !!} (approx {!!  $project->euro_amount  !!} Euro)</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Fund Group Amount :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!!  $project->gf_commission  !!} in {!!  $project->currency  !!}</p>
        </div>
        <div class="row">
            <p class="col-xs-12 col-md-3 text-primary pull-left">Description :</p>
            <p class="col-xs-12 col-md-6 text-muted pull-left">{!! $strippedProjectDesc !!}</p>
        </div>
    </div>
  </div>
</div>
