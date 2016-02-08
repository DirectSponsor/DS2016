<div class="clearfix">
    <span id="recipient-iinfo-icon" class="vertical-middle pointer glyphicon glyphicon-plus-sign" data-toggle="collapse" data-target="#recipient-iinfo"></span>
    <p id="recipient-iinfo-collapse-text" class="col-xs-10 col-md-2 text-warning">
        Show Recipient Detail
    </p>
</div>

<div id="recipient-iinfo" class="collapse">
    <h4>Recipient Information: </h4>
    @include('recipients.info')
</div>


<h2> Received Payments: </h2><?php $payments = $recipient->receivedPayments; $profileAccountType = 'Recipient'; ?>
@include('payments.recipient_coordinator_view')