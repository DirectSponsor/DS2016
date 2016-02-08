<div class="infos">
    <div class="row">
        <p class="col-xs-12 col-md-3 text-primary pull-left">Recipient Name :</p>
        <p class="col-xs-12 col-md-6 text-muted pull-left">{!!  $recipient->user->account->name  !!}</p>
    </div>
    <div class="row">
        <p class="col-xs-12 col-md-3 text-primary pull-left">Recipient Email :</p>
        <p class="col-xs-12 col-md-6 text-muted pull-left">{!!  $recipient->user->email  !!}</p>
    </div>
    <div class="row">
        <p class="col-xs-12 col-md-3 text-primary pull-left">Recipient Skrill Email :</p>
        <p class="col-xs-12 col-md-6 text-muted pull-left">{!!  $recipient->user->account->skrill_acc  !!}</p>
    </div>
    <div class="row">
        <p class="col-xs-12 col-md-3 text-primary pull-left">Number of sponsors :</p>
        <a href="{!! URL::route('mySponsors') !!}" class="col-xs-12 col-md-6 pull-left">{!!  $recipient->sponsors->count()  !!}</a>
    </div>
</div>
