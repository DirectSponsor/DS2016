<!-- Modal Confirm Payment -->
<div class="modal fade" id="paymentRecipientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title lead text-warning" id="myModalLabel">Confirm Payment from Sponsor</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                {!!  Form::label('payment_amount',' Please enter the amount received in your local currency: ') !!}
            </div>
            <div class="row">
                {!! Form::text('amount', Input::old('amount'))  !!}
            </div>
            <div id="error-list-paymentRecipientModal" class="row">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-submit-payment">Submit Payment</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirm Late Payment -->
<div class="modal fade" id="paymentLateRecipientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title lead text-warning" id="myModalLabel">Confirm Payment is Late from Sponsor</h4>
      </div>
      <div class="modal-body">
          <p>Note:  When you confirm this payment is late, a reminder email will be sent to the Sponsor.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-confirm-late-payment">Confirm Late</button>
      </div>
    </div>
  </div>
</div>

<script>
    var selectedPaymentURL = '';
    var selectedLatePaymentURL = '';

    $(document).ready(function(){
        $('#paymentRecipientModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          selectedPaymentURL = button.attr('URL');
          $('#error-list-paymentRecipientModal').html("");
        })
        $('button.btn-submit-payment').on('click', function(e) {
            tokenVal = $('input[name="_token"]').val();
            amount = $('input[name="payment_amount"]').val();
            $('#error-list-paymentRecipientModal').html("");
            $.ajax({
                url: selectedPaymentURL,
                type: 'PUT',
                dataType: "json",
                data: {'_token' : tokenVal, 'amount' : amount},
                success: function(data) {
                    if (data.result === 'success') {
                        window.location.reload(true);
                    } else {
                        $('#error-list-paymentRecipientModal').append(
                                '<p class="text-primary">Errors:</p>');
                        $.each( data.errors, function( key, value ) {
                            $('#error-list-paymentRecipientModal').append(
                                    '<p class="text-danger">'+
                                    value+
                                    '</p>');
                        });
                    }
                }
            });
            return true;
        });

        $('#paymentLateRecipientModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          selectedLatePaymentURL = button.attr('URL');
        })
        $('button.btn-confirm-late-payment').on('click', function(e) {
            tokenVal = $('input[name="_token"]').val();
            $.ajax({
                url: selectedLatePaymentURL,
                type: 'PUT',
                dataType: "json",
                data: {'_token' : tokenVal},
                success: function(data) {
                    if (data.result === 'success') {
                        window.location.reload(true);
                    } else {
                        alert('System Error: Contact Administrator to report error.\n'+data.result)
                    }
                }
            });
            return true;
        });
    });
</script>