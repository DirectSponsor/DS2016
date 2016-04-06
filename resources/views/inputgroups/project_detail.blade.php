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
                        'label' => 'Name of Project (160 chars) : <cite class="text-muted">Characters Remaining:&nbsp;<span id="projectTextCounter">000</span></cite>',
                        'onkeyup' => "textCounter(this,'projectTextCounter',160);",
                        ],
                        1,
                        160)
                    )
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    @include('elements.select', element::inputDefaults(['value' => $project->status,
                        'name' => 'status', 'label' => 'Status :',
                        'options' => element::getEnumValueList('project', 'status'), 'placeholder' => 'Select Status',
                        'dataActions' => 'true', 'readonly' => 'true',
                        'class' => 'selectpicker'
                        ]))
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input_currency', element::inputDefaults(
                    ['value' => old('initial_target_euro_budget', $project->initial_target_euro_budget),
                    'name' => 'initial_target_euro_budget',  'currency' => '€',
                    'label' => 'Initial Budget Target (euro):', 'classlabel' => 'clearfix'
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input', element::inputDefaults(
                    ['value' => old('currency_conversion_factor', $project->currency_conversion_factor),
                    'name' => 'currency_conversion_factor',
                    'label' => 'Currency Conversion Factor:', 'classlabel' => 'clearfix'
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input', element::inputDefaults(
                    ['value' => old('max_recipients', $project->max_recipients),
                    'name' => 'max_recipients',
                    'label' => 'Maximum No. Recipients:', 'classlabel' => 'clearfix'
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input', element::inputDefaults(
                    ['value' => old('max_sponsors', $project->max_sponsors),
                    'name' => 'max_sponsors',
                    'label' => 'Maximum No. Sponsors per Recipient:', 'classlabel' => 'clearfix'
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input', element::inputDefaults(
                    ['value' => old('local_currency', $project->local_currency),
                    'name' => 'local_currency',
                    'label' => 'Local Currency Name (50 chars) : <cite class="text-muted">Characters Remaining:&nbsp;<span id="localCurrencyTextCounter">000</span></cite>',
                    'onkeyup' => "textCounter(this,'localCurrencyTextCounter',50);",
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input', element::inputDefaults(
                    ['value' => old('local_currency_symbol', $project->local_currency_symbol),
                    'name' => 'local_currency_symbol',
                    'label' => 'Currency Symbol:', 'classlabel' => 'clearfix'
                    ])
                )
            </div>

        </div>
    </div>
    <div class="panel-heading">
        <h3 class="panel-title">Project Amounts</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input_currency', element::inputDefaults(
                    ['value' => old('min_euro_amount_per_recipient', $project->min_euro_amount_per_recipient),
                    'name' => 'min_euro_amount_per_recipient', 'currency' => '€',
                    'label' => 'Minimum Euro Amount per recipient:', 'classlabel' => 'clearfix'
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input_currency', element::inputDefaults(
                    ['value' => old('max_euro_amount_per_recipient', $project->max_euro_amount_per_recipient),
                    'name' => 'max_euro_amount_per_recipient', 'currency' => '€',
                    'label' => 'Maximum Euro Amount per recipient:', 'classlabel' => 'clearfix',
                    'readonly' => true
                    ])
                )
            </div>

            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input_currency', element::inputDefaults(
                    ['value' => old('min_local_amount_per_recipient', $project->min_local_amount_per_recipient),
                    'name' => 'min_local_amount_per_recipient', 'currency' => $project->local_currency_symbol,
                    'label' => 'Minimum Local Amount per recipient:', 'classlabel' => 'clearfix',
                    'readonly' => true
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input_currency', element::inputDefaults(
                    ['value' => old('max_local_amount_per_recipient', $project->max_local_amount_per_recipient),
                    'name' => 'max_local_amount_per_recipient', 'currency' => $project->local_currency_symbol,
                    'label' => 'Maximum Local Amount per recipient:', 'classlabel' => 'clearfix',
                    'readonly' => true
                    ])
                )
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                @include('elements.input_currency', element::inputDefaults(
                    ['value' => old('min_local_amount_retained_recipient', $project->min_local_amount_retained_recipient),
                    'name' => 'min_local_amount_retained_recipient', 'currency' => $project->local_currency_symbol,
                    'label' => 'Minimum Local Amount Retained by recipient:', 'classlabel' => 'clearfix'
                    ])
                )
            </div>
        </div>
    </div>
    <div class="panel-heading">
        <h3 class="panel-title">Description</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-12 form-group">
                @include('elements.textarea', element::textarea(
                    ['value' => old('description', $project->description),
                    'name' => 'description',
                    'label' => 'Description of Project (255 chars) : <cite class="text-muted">Characters Remaining:&nbsp;<span id="descriptionTextCounter">000</span></cite>',
                    'onkeyup' => "textCounter(this,'descriptionTextCounter',255);",
                    ],
                    4,
                    100)
                )
            </div>
        </div>
    </div>
</div>
