<!-- Modal Change Password -->
<div class="modal fade" id="changepasswordmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title lead text-warning" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                {!! Form::label('current_password','Current Password :', array('class' => 'col-xs-12 col-md-3')),
                    Form::password('current_password', array('class' => 'col-xs-12 col-md-5'))  !!}
                    @if($errors->has('current_password')) {!!  $errors->first('current_password','<p class="text-danger"> :message </p>')  !!} @endif
            </div>
            <div class="row">
                {!! Form::label('password','New Password :', array('class' => 'col-xs-12 col-md-3')),
                    Form::password('password', array('class' => 'col-xs-12 col-md-5'))  !!}
                    @if($errors->has('password')) {!!  $errors->first('password','<p class="text-danger"> :message </p>')  !!} @endif
            </div>
            <div class="row">
                {!! Form::label('password_confirmation','Retype New Password :', array('class' => 'col-xs-12 col-md-3')),
                    Form::password('password_confirmation', array('class' => 'col-xs-12 col-md-5'))  !!}
                    @if($errors->has('password_confirmation')) {!!  $errors->first('password_confirmation','<p class="text-danger"> :message </p>')  !!} @endif
            </div>

            <div id="error-list-changepasswordmodal" class="row">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-change-password">Change Password</button>
      </div>
    </div>
  </div>
</div>

<script>
    var selected_update_password_url = '';

    $(document).ready(function(){
        $('#changepasswordmodal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          selected_update_password_url = button.attr('URL');
          $('#error-list-changepasswordmodal').html("");
        })
        $('button.btn-change-password').on('click', function(e) {
            tokenVal = $('input[name="_token"]').val();
            $('#error-list-changepasswordmodal').html("");
            $.ajax({
                url: selected_update_password_url,
                type: 'PUT',
                dataType: "json",
                data: {'_token' : tokenVal, 'current_password' : $("input[name='current_password']").val(),
                    'password' : $("input[name='password']").val(), 'password_confirmation' : $("input[name='password_confirmation']").val()},
                success: function(data) {
                    if (data.result === 'success') {
                        window.location.reload(true);
                    } else {
                        $('#error-list-changepasswordmodal').append(
                                '<p class="text-primary">Errors:</p>');
                        $.each( data.errors, function( key, value ) {
                            $('#error-list-changepasswordmodal').append(
                                    '<p class="text-danger">'+
                                    value+
                                    '</p>');
                        });
                    }
                }
            });
            return true;
        });
    });
</script>