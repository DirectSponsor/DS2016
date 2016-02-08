<h2>Information: </h2>
<div class="infos">
    <p class="field"> Username </p><p class="value">{!!  $coord->user->username  !!}</p><div class="clear"></div>
    <p class="field"> Email </p><p class="value">{!!  $coord->user->email  !!}</p><div class="clear"></div>
    <p class="field"> Skrill Account </p><p class="value">{!!  $coord->skrill_acc  !!}</p><div class="clear"></div>
    <p class="field"> Join date </p><p class="value">{!!  $coord->created_at  !!}</p><div class="clear"></div>
    <div class="clear"></div>
</div>

<h2> Received Payments: </h2><?php $payments = $coord->receivedPayments; $profileAccountType = 'Coordinator'; ?>
@include('payments.index')