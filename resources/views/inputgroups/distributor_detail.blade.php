<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<?php
    $placeholders = [
        'trading_name' => 'Company Name or Trading As Name',
        'website' => 'e.g. www.mysite.com',
        'phone' => 'Landline office number',
        'sales_email' => 'For Sales Enquiries'
    ];
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Contact Information</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-6 form-group">
                @if($distributor->trading_name != 'Own distribution coverage')
                    @include('elements.input', element::inputDefaults(['value' => old('trading_name', $distributor->trading_name), 'name' => 'trading_name', 'label' => 'Trading As :']) )
                @else
                    @include('elements.input', element::inputTextReadOnly(['value' => $distributor->trading_name, 'name' => 'trading_name', 'label' => 'Trading As :']) )
                @endif
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputDefaults(['value' => old('phone', $distributor->phone), 'name' => 'phone', 'label' => 'Phone :']))
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputDefaults(['value' => old('sales_email', $distributor->sales_email), 'name' => 'sales_email', 'label' => 'Sales Email :', 'type' => 'email']))
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputDefaults(['value' => old('website', $distributor->website), 'name' => 'website', 'label' => 'Website :']))
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Distribution Information</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            @include('elements.label', ['label' => 'Zones :'])
            <div class='col-xs-12 col-md-6 form-group'>
                @include('elements.selectMultiple', element::inputDefaults(['value' => old('zones', $distributor->zones), 'name' => 'zones',
                'options' => element::getSetValueList('distributors', 'zones'), 'placeholder' => 'Select Zones',
                'class' => 'selectpicker']))
            </div>
            <div class='col-xs-12 col-md-6 form-group'>
                @include('elements.input', element::checkbox(['value' => old('bulk_indic', $distributor->bulk_indic), 'name' => 'bulk_indic',
                'label' => 'Bulk Distribution:&nbsp;', 'class' => 'col-xs-2']) )
            </div>
        </div>
        <div class="row">
            @include('elements.label', ['label' => 'Regions', 'labelclass' => 'xxx'])
            <div class='col-xs-12 col-md-6 form-group'>
                @include('elements.selectMultiple', element::inputDefaults(['value' => old('local_county', $distributor->local_county), 'name' => 'local_county',
                'options' => element::getSetValueList('distributors', 'local_county'), 'placeholder' => 'Select Counties',
                'dataActions' => 'true', 'readonly' => 'true',
                'label' => 'Counties:&nbsp;',
                'class' => 'selectpicker']))
            </div>
            <div class='col-xs-12 col-md-6 form-group'>
                @include('elements.selectMultiple', element::inputDefaults(['value' => old('europe_country', $distributor->europe_country), 'name' => 'europe_country',
                'options' => element::getSetValueList('distributors', 'europe_country'), 'placeholder' => 'Select European Countries',
                'dataActions' => 'true', 'readonly' => 'true',
                'label' => 'Countries:&nbsp;',
                'class' => 'selectpicker']))
            </div>
        </div>
    </div>
</div>
