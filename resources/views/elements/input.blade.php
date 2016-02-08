<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->


@if ($label == true)
    <label for="{{ $name }}" class="control-label pull-left {{ $classlabel or "noclasslabel" }}">{{ $label }}</label>
@endif

@if ($readonly == true)
    <input readonly="readonly" name="{{ $name }}" id="{{ $name }}" size="3" type="{{ $type }}" value="{{ $value }}" class="{{ $class }}"
           @if (isset($checked)) checked='' @endif
           />
@else
    <input name="{{ $name }}" id="{{ $name }}" type="{{ $type }}" value="{{ $value }}" class="{{ $class }}" placeholder="{{ $placeholders[$name] or '' }}"
        @if(isset($checked)) checked='' @endif
        @if($type=='date') data-provide="datepicker-inline" @endif
    />

    @if ($errors->first($name) !== '')
        <p class="text-danger">{{ $errors->first($name) }}</p>
    @endif
@endif
@if ($label == true)
<br>
@endif

