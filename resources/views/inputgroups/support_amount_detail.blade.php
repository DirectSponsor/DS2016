<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<?php
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Project Information</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class='wrapper cols-xs-12 clearfix'>
                <div class="col-xs-12 col-sm-6 form-group">
                    @include('elements.textarea', element::textarea(
                        ['value' => old('name', $project->name),
                        'name' => 'name',
                        'label' => 'Name of Project:',
                        'readonly' => true
                        ],
                        1,
                        160)
                    )
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    @include('elements.select', element::inputDefaults(['value' => $project->status,
                        'name' => 'status', 'label' => 'Status :',
                        'options' => element::getEnumValueList('project', 'status'), 'placeholder' => 'Select Status',
                        'dataActions' => 'true', 'readonly' => true,
                        'class' => 'selectpicker'
                        ]))
                </div>
            </div>
        </div>
    </div>
    <div class="panel-heading">
        <h3 class="panel-title">Select Support Commitment</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.selectMultiple', element::inputDefaults(['value' => '',
                    'name' => 'amount_selected', 'label' => 'Amounts :',
                    'options' => $amounts, 'noMultiple' => 'true',
                    'placeholder' => 'Select Amount', 'title' => 'Select Amount',
                    'dataActions' => 'true',
                    'class' => 'selectpicker'
                    ]))
            </div>
        </div>
    </div>
</div>
