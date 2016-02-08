<div class='row'>
    {!!
        Form::label('name','Name :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('name',Input::old('name'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('name')) {!!  $errors->first('name','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('max_recipients',' Max Recipients :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('max_recipients',Input::old('max_recipients'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('max_recipients')) {!!  $errors->first('max_recipients','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('max_sponsors_per_recipient',' Max Sponsors per Recipient :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('max_sponsors_per_recipient',Input::old('max_sponsors_per_recipient'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('max_sponsors_per_recipient')) {!!  $errors->first('max_sponsors_per_recipient','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('max_recipients_per_sponsor',' Max Recipients per Sponsor :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('max_recipients_per_sponsor',Input::old('max_recipients_per_sponsor'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('max_recipients_per_sponsor')) {!!  $errors->first('max_recipients_per_sponsor','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<hr>
<div class='row'>
    {!!
        Form::label('currency',' Currency :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('currency',Input::old('currency'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('currency')) {!!  $errors->first('currency','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('amount',' Amount :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('amount',Input::old('amount'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('amount')) {!!  $errors->first('amount','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('euro_amount',' Amount in Euro :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('euro_amount',Input::old('euro_amount'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('euro_amount')) {!!  $errors->first('euro_amount','<p class="text-danger"> :message </p>')  !!} @endif
</div>

<div class='row'>
    {!!
        Form::label('recipient_amount_local_currency','Recipient Amount :', array('class' => 'col-xs-12 col-md-3')),
        Form::text('recipient_amount_local_currency',Input::old('recipient_amount_local_currency'), array('class' => 'col-xs-12 col-md-6'))  !!}
        @if($errors->has('recipient_amount_local_currency')) {!!  $errors->first('recipient_amount_local_currency','<p class="text-danger"> :message </p>')  !!} @endif
</div>
<div class='row center'>
    {!!
        Form::submit('Save Project Details', array('class' => 'btn btn-primary btn-xs pull-left botGap topGap')),
        Form::close()
        !!}
    @if($project->id > 0)
    {!!
        Form::open(array('class'=>'inline', 'method'=>'get','route'=>array('coordinators.edit',$project->id))),
        Form::submit('Edit Coordinator', array('class' => 'btn btn-primary btn-xs pull-right botGap topGap')),
        Form::close()
        !!}
    @endif
</div>

</div>
