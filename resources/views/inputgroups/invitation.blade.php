<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
{!! csrf_field() !!}
<div class="row">
    <div class="col-md-6 form-group">
        <label for="email">Email</label>
        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="role_id">Role</label>
        {!! Form::select('role_id', $roles, null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label class="wrap-selector" for="certbody_id">Certification Body</label>
        {!! Form::select('certbody_id', $certbodies, null, array('class' => 'form-control')) !!}
    </div>
</div>
