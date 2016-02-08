<table class="table data table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>Due Date</th>
            <th>For Month</th>
            <th>Sponsor</th>
            <th>Skrill Account</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(!count($payments)){
            echo '<tr><td colspan = "7">There are no transactions !</td></tr>';
        }
    ?>
    @foreach($payments as $payment)
        <tr>
            <td>{!!  $payment->due_date->format('Y/m/d')  !!}</td>
            <td>{!!  $payment->pay_month  !!}</td>
            <td> @if($payment->type == "sponsoring")
                {!!  $payment->sender->username  !!}
            @else
                Error ! (Please report it)
            @endif </td>
            <td> @if($payment->type == "sponsoring")
                {!!  $payment->sender->account->skrill_acc  !!}
            @else
                Error ! (Please report it)
            @endif </td>
            <td>{!!  $payment->stat  !!}</td>
            <td>{!!  $payment->amount_local  !!}</td>
            <td>
                @if(($payment->stat == "pending") || ($payment->stat == "late"))
                    {!! Form::button('Confirm',
                        array('class' => 'btn btn-primary btn-sm btn-confirm-payment',
                            'data-toggle' => 'modal',
                            'data-target' => '#paymentRecipientModal',
                            'URL' => route('payments.accept', ['pid' => $payment->id])
                            )) !!}
                @endif
                @if($payment->overduePayment())
                    {!! Form::button('Confirm Late',
                        array('class' => 'btn btn-primary btn-sm btn-late-payment',
                            'data-toggle' => 'modal',
                            'data-target' => '#paymentLateRecipientModal',
                            'URL' => route('payments.late', ['pid' => $payment->id])
                            )) !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! Form::token() !!}

@include('payments.recipientPayment_modal')
