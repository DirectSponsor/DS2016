<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<div class="row">
    <div class="col-xs-12 col-md-6 form-group">
        @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'email', 'label' => 'Email :']) )
        @include('elements.input', element::inputDefaults(['value' => null, 'name' => 'password', 'type' => 'password', 'label' => 'Password :']) )
        @include('elements.input', element::checkbox(['value' => null, 'name' => 'remember',
        'label' => 'Remember Me :', 'classlabel' => 'col-xs-10 col-md-6', 'class' => 'col-xs-2 col-md-1']) )
    </div>
</div>
 