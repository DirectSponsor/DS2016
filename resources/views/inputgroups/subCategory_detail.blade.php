<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->
<?php
    $placeholders = [
        'multi_lang_seo_text' => 'Enter other english or foreign language variations for this category'
    ];
?>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Category Entry</h3>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-md-6 form-group">
                @if(Request::segment(2) == 'add')
                    @include('elements.select', element::inputDefaults(['value' => $subCategory->category_id, 'name' => 'category_id', 'label' => 'Category :',
                        'options' => $categories]))
                @else
                    @include('elements.input', element::inputTextReadOnly(['value' => $subCategory->category->category_text, 'name' => 'category_text', 'label' => 'Category :']) )
                @endif
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                @if(Request::segment(2) == 'add')
                    @include('elements.input', element::inputDefaults(['value' => $subCategory->sub_category_text, 'name' => 'sub_category_text', 'label' => 'Sub-category :']) )
                @else
                    @include('elements.input', element::inputTextReadOnly(['value' => $subCategory->sub_category_text, 'name' => 'sub_category_text', 'label' => 'Sub-category :']) )
                @endif
            </div>
            @if(Auth::user()->isSiteAdmin())
            <div class="col-xs-12 col-md-12 form-group">
                @include('elements.textarea', element::textarea(
                    ['value' => old('multi_lang_seo_text', $subCategory->multi_lang_seo_text),
                    'name' => 'multi_lang_seo_text',
                    'label' => 'Language Variations : '], 4, 60)
                )
            </div>
            @else
            <div class="col-xs-12 col-md-12 form-group">
                @include('elements.textarea', element::textarea(
                    ['value' => old('multi_lang_seo_text', $subCategory->multi_lang_seo_text),
                    'name' => 'multi_lang_seo_text', 'readonly' => true,
                    'label' => 'Language Variations : '], 4, 60)
                )
            </div>
            @endif
            <div class="col-xs-12 col-md-12 form-group">
                @include('elements.textarea', element::textarea(
                    ['value' => old('append_text', $append_text),
                    'name' => 'append_text',
                    'label' => 'Append to Language Variations : '], 4, 60)
                )
            </div>
         </div>
    </div>
</div>
