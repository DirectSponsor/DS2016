<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<?php
    $placeholders = [
        'trading_name' => 'Company Name or Trading As Name',
        'website' => 'e.g. www.mysite.com',
        'mobile' => 'Mobile number',
        'phone' => 'Landline office number',
        'fax' => 'Fax number',
        'addr_line_1' => 'Line 1',
        'addr_line_2' => 'Line 2',
        'addr_line_3' => 'Line 3',
        'county' => 'Select County',
        'country' => 'Select Country',
        'sales_email' => 'For Sales Enquiries',
        'facebook' => 'Facebook link for your products or business',
        'twitter' => 'Your Twitter link',
        'linkedin' => 'Your LinkedIN Profile link',
        'profile_text' => 'Enter description of your business, products, etc',
    ];
?>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Approver Information</h3>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-md-6 form-group">
                <br>
                @include('elements.input', element::inputTextReadOnly(['value' => $bodyname, 'name' => 'bodyname', 'label' => 'Certification Body :']) )
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                <br>
                <?php $certbodyAdminUser = Auth::user()->isCertbodyAdmin(); ?>
                @if($certbodyAdminUser)
                    @include('elements.input', element::checkbox(['value' => old('approved_indic', $producer->approved_indic), 'name' => 'approved_indic', 'label' => 'Approved :', 'class' => 'col-md-1']) )
                @else
                    @include('elements.input', element::checkboxReadOnly(['value' => $producer->approved_indic, 'name' => 'approved_indic', 'label' => 'Approved :', 'class' => 'col-md-1']) )
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Your Profile</h3>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputTextReadOnly(['value' => $producer->user->name, 'name' => 'username', 'label' => 'Producer Name :']) )
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputTextReadOnly(['value' => $producer->certbody->ocb_code .'-'. $producer->licence_no, 'name' => 'licence_no', 'label' => 'Licence :']) )
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputDefaults(['value' => old('trading_name', $producer->trading_name), 'name' => 'trading_name', 'label' => 'Trading As :']) )
            </div>
            <div class="col-xs-12 col-md-12 form-group">
                @include('elements.textarea', element::textarea(
                    ['value' => old('profile_text', $producer->profile_text),
                    'name' => 'profile_text',
                    'label' => 'About Company (160 chars) : <cite class="text-muted">Characters Remaining:&nbsp;<span id="profileTextCounter">000</span></cite>',
                    'onkeyup' => "textCounter(this,'profileTextCounter',160);",
                    ],
                    3,
                    60)
                )
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Contact &amp; Social Media Information</h3>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputDefaults(['value' => old('sales_email', $producer->sales_email), 'name' => 'sales_email', 'label' => 'Sales Email :', 'type' => 'email']))
                @include('elements.input', element::inputDefaults(['value' => old('website', $producer->website), 'name' => 'website', 'label' => 'Website :']))
                @include('elements.input', element::inputDefaults(['value' => old('facebook', $producer->facebook), 'name' => 'facebook', 'label' => 'Facebook :']))
                @include('elements.input', element::inputDefaults(['value' => old('twitter', $producer->twitter), 'name' => 'twitter', 'label' => 'Twitter :']))
                @include('elements.input', element::inputDefaults(['value' => old('linkedin', $producer->linkedin), 'name' => 'linkedin', 'label' => 'LinkedIn :']))

            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputDefaults(['value' => old('phone', $producer->phone), 'name' => 'phone', 'label' => 'Phone :']))
                @include('elements.input', element::inputDefaults(['value' => old('mobile', $producer->mobile), 'name' => 'mobile', 'label' => 'Mobile :']))
                @include('elements.input', element::inputDefaults(['value' => old('fax', $producer->fax), 'name' => 'fax', 'label' => 'Fax :']))

                @include('elements.label', ['label' => 'Address :'])
                @include('elements.input', element::inputDefaults(['value' => old('addr_line_1', $producer->addr_line_1), 'name' => 'addr_line_1']))
                @include('elements.input', element::inputDefaults(['value' => old('addr_line_2', $producer->addr_line_2), 'name' => 'addr_line_2']))
                @include('elements.input', element::inputDefaults(['value' => old('addr_line_3', $producer->addr_line_3), 'name' => 'addr_line_3']))
                @include('elements.select', element::inputDefaults(['value' => old('county', $producer->county), 'name' => 'county', 'options' => element::getEnumValueList('producers', 'county')]))
                @include('elements.select', element::inputDefaults(['value' => old('country', $producer->country), 'name' => 'country', 'options' => element::getEnumValueList('producers', 'country')]))
            </div>
        </div>
    </div>
</div>
