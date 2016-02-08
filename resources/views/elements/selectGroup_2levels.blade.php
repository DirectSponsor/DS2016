<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->



@if ($label == true)
    <label for="{{ $name }}" class="control-label pull-left">{{ $label }}</label>
@endif

<select name="{{ $name }}" id="{{ $name }}" class="{{ $class }}" autocomplete="off" placeholder="Select Value">
    @foreach($options as $optionGroup => $optionsArray)
        <optgroup label='{{ $optionGroup }}'>

        @foreach($optionsArray as $key => $option)
            @if ($value == $key)
                <option value="{{ $key }}" selected="selected">{{ $option }}</option>
            @else
                <option value="{{ $key }}">{{ $option }}</option>
            @endif
        @endforeach

        </optgroup>
    @endforeach
</select>
@if($errors->has('{{ $name }}')) {!!  $errors->first('{{ $name }}','<p class="text-danger"> :message </p>')  !!} @endif

@if ($label == true)
<br>
@endif
