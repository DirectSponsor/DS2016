<!-- Modal -->
<div class="modal fade" id="suspendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title lead text-warning" id="myModalLabel">Withdraw from Project Sponsorship</h4>
      </div>
      <div class="modal-body">
          <p>
              Please note that by withdrawing, you will cease to be a sponsor for this project. <br/>You can rejoin this project again.
          </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-confirm-withdraw">Confirm Withdrawal</button>
      </div>
    </div>
  </div>
</div>
<script>
    var selectedProjectURL = '';
    $(document).ready(function(){
        $('button.btn-withdraw').on('click', function(e) {
            selectedProjectURL = $(this).attr('URL');
            return true;
        });
        $('button.btn-confirm-withdraw').on('click', function(e) {
            tokenVal = $('input[name="_token"]').val();
            $.ajax({
                url: selectedProjectURL,
                type: 'DELETE',
                dataType: "json",
                data: {'_token' : tokenVal},
                success: function(data) {
                    if (data.result === 'success') {
                        window.location.reload(true);
                    } else {
                        alert('System Error: Contact Administrator to report error.')
                    }
                }
            });
            return true;
        });
    });
</script>