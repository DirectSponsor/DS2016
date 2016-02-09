<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<?php
    $placeholders = [
        'product_text' => 'Describe product....'
    ];
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Product Information</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.selectGroup_2levels', element::inputDefaults(['value' => old('sub_category_id', $product->sub_category_id), 'name' => 'sub_category_id', 'options' => $categories, 'label' => 'Select Product Category', 'class' => 'text-left']))
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 form-group">
                @include('elements.textarea', element::textarea(
                    ['value' => old('product_text', $product->product_text),
                    'name' => 'product_text',
                    'label' => 'About Product (160 chars) : <cite class="text-muted">Characters Remaining:&nbsp;<span id="productTextCounter">000</span></cite>',
                    'onkeyup' => "textCounter(this,'productTextCounter',160);",
                    ],
                    3,
                    60)
                )
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Product Image</h3>
    </div>
    <div class="panel-body">
        @if($product->image_uploaded_indic)
        <div class="row">
            <div class="col-xs-12 col-md-6 form-group">
                {!! Form::label('Photo :') !!}
                <img class='img-responsive' src='/producer_images/img_{{ $imageFileName }}.jpg'/>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-6 form-group">
                @if($product->image_uploaded_indic)
                    @include('elements.file', ['value' => old('image'), 'name' => 'image', 'label' => 'Replace Photo - Select file (jpeg,jpg,gif,png) :',
                        'classlabel' => 'col-xs-12 col-md-12', 'class' => 'col-xs-12 col-md-12'])
                @else
                    @include('elements.file', ['value' => old('image'), 'name' => 'image', 'label' => 'Add Photo - Select file (jpeg,jpg,gif,png) :',
                        'classlabel' => 'col-xs-12 col-md-12', 'class' => 'col-xs-12 col-md-12'])
                @endif
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @include('elements.input', element::inputDefaults(['value' => old('caption', $product->caption), 'name' => 'caption', 'label' => 'Caption :']))
                @if($errors->has('{{ $caption }}')) {!!  $errors->first('{{ $caption }}','<p class="text-danger"> :message </p>')  !!} @endif
            </div>

        </div>
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 form-group">
                <p class="text-notification">Make this the Primary photo for your profile</p>
                @include('elements.input', element::checkbox(['value' => old('primary_indic', $product->primary_indic), 'name' => 'primary_indic',
                'label' => 'Primary:', 'classlabel' => 'col-xs-6 col-md-4', 'class' => 'col-xs-2 col-md-1']) )
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                <p class="text-danger">Delete this photo?</p>
                @include('elements.input', element::checkbox(['value' => old('image_delete'), 'name' => 'image_delete',
                'label' => 'Check to delete:', 'classlabel' => 'text-danger col-xs-6 col-md-4', 'class' => 'col-xs-2 col-md-1']) )
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                <p class="text-notification">Approve Photo for display</p>
                <?php $certbodyAdminUser = Auth::user()->isCertbodyAdmin(); ?>
                @if($certbodyAdminUser)
                    @include('elements.input', element::checkbox(['value' => old('approved_indic', $product->approved_indic), 'name' => 'approved_indic',
                    'label' => 'Approved:', 'classlabel' => 'col-xs-6 col-md-4', 'class' => 'col-xs-2 col-md-1']) )
                @else
                    @include('elements.input', element::checkboxReadOnly(['value' => $product->approved_indic, 'name' => 'approved_indic',
                    'label' => 'Approved:', 'classlabel' => 'col-xs-6 col-md-4', 'class' => 'col-xs-2 col-md-1']) )
                @endif
            </div>
        </div>
    </div>
</div>
