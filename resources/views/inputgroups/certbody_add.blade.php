<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<?php
    $placeholders = [
        'name' => 'Enter name of certification body',
        'launch_date' => 'Enter date of launch'
    ];
?>

<div class="row">
    <div class="col-xs-12 form-group">
        @include('elements.input', element::inputDefaults(['value' => $certbody->name, 'name' => 'name', 'label' => 'Name of body :']) )
    </div>
    <div class="col-xs-12 col-md-6 form-group">
        @include('elements.input', element::inputDefaults(['value' => $certbody->ocb_code, 'name' => 'ocb_code',
        'class' => 'col-disable',
        'label' => 'OCB Code :']) )
    </div>
    <div class="col-xs-12 col-md-6 form-group">
        @include('elements.input', element::inputDefaults(['value' => $certbody->launch_date,
            'name' => 'launch_date', 'label' => 'Launch Date :',
            'class' => 'col-disable',
            'type' => 'date']))
    </div>
</div>