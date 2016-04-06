<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->



@if ($label == true)
    <label for="{{ $name }}" class="control-label pull-left">{!! $label !!}</label>
@endif

<select name="{{ $name }}" id="{{ $name }}" class="{{ $class }}" autocomplete="off"
        alt="{{ $title or 'Select Value' }}"
        title="{{ $placeholder or 'Select Value' }}"
        data-size="{{ $dataSize or '9'}}"
        @if($readonly == true) disabled @endif 
        @if(isset($dataActions)) data-actions-box="true" @endif
        data-header="{{ $placeholder or 'Select Value' }}"
        data-hint="{{ $title or 'Select Value' }}"
        placeholder="{{ $placeholder or 'Select Value' }}">

        @foreach($options as $key => $option)
            @if ($value == $key)
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
