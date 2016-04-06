<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
 <div class='col-xs-11 col-xs-offset-1 col-sm-4 col-sm-offset-1 pull-left'>
    @include('elements.input', element::inputDefaults(['value' => old('email', null),
        'name' => 'email', 'label' => 'User Email :', 'type' => 'email',
        'class' => 'col-xs-12 col-sm-7', 'classLabel' => 'col-xs-12 col-sm-4']))
</div>
 <div class='col-xs-11 col-xs-offset-1 col-sm-3 col-sm-offset-1  pull-left'>
    @include('elements.input', element::inputDefaults(['value' => old('role_type', null),
        'name' => 'role_type', 'label' => 'Role :', 'type' => 'text',
        'class' => 'col-xs-12 col-sm-8', 'classLabel' => 'col-xs-12 col-sm-3',
        'dataList' => array('Recipient', 'Coordinator')]
        ))
 </div>
