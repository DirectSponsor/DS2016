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
    <div class="col-xs-12 col-md-6 form-group">
        @if(Auth::user()->isSiteAdmin())
           @include('elements.input', element::inputDefaults(['value' => $certbody->name, 'name' => 'name', 'label' => 'Name of body :']) )
           @include('elements.input', element::inputDefaults(['value' => $certbody->ocb_code, 'name' => 'ocb_code', 'label' => 'OCB Code :']) )
        @else
           @include('elements.input', element::inputTextReadOnly(['value' => $certbody->name, 'name' => 'name', 'label' => 'Name of body :']) )
           @include('elements.input', element::inputTextReadOnly(['value' => $certbody->ocb_code, 'name' => 'ocb_code', 'label' => 'OCB Code :']) )
        @endif
    </div>
   <div id='dateLaunchDiv' class="col-xs-12 col-md-3 form-group">
       @include('elements.input', element::inputDefaults(['value' => $certbody->launch_date->format('d/m/Y'),
           'name' => 'launch_date',
           'class' => 'values__datepicker',
           'label' => 'Launch Date :']))
       @include('elements.input', element::checkbox(['value' => $certbody->launch_indic, 'name' => 'launch_indic',
           'label' => 'Launch:&nbsp;', 'class' => 'col-xs-2']) )
   </div>
 </div>