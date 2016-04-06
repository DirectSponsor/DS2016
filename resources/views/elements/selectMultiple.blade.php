<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->



@if ($label == true)
    <label for="{{ $name }}" class="control-label pull-left">{!! $label !!}</label>
@endif

<select name="{{ $name }}[]" id="{{ $name }}"
        @if(!isset($noMultiple))
            multiple
        @endif
        class="{{ $class }}" autocomplete="off"
        data-hint="{{ $title or 'Select Value' }}"
        title="{{ $placeholder or 'Select Value' }}" data-size="10"
        data-header="{{ $placeholder or 'Select Value' }}"
        @if(isset($dataSelectedTextFormat))
            data-selected-text-format="{{ $dataSelectedTextFormat }}"
        @else
            data-selected-text-format="count > 6"
        @endif

        @if($readonly == true) disabled @endif
        @if(isset($dataActions)) data-actions-box="true" @endif
        >

        @foreach($options as $key => $option)
            @if (is_array($value) && in_array($key, $value))
                <option value="{{ $key }}" selected="selected">{{ $option }}</option>
            @else
                <option value="{{ $key }}">{{ $option }}</option>
            @endif
        @endforeach
</select>
    @if ($errors->first($name) !== '')
        <p class="text-danger">{{ $errors->first($name) }}</p>
    @endif

@if ($label == true)
<br>
@endif
