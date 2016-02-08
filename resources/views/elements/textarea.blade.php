<!--
  This file is part of Organic Directory Application

  @copyright Copyright (c) 2016 McGarryIT
  @link      (http://www.mcgarryit.com)
 -->


@if ($label == true)
    <label for="{{ $name }}" class="control-label pull-left">{!! $label !!}</label>
@endif
@if ($readonly == true)
    <textarea rows="{{ $rows }}" cols="{{ $cols }}" readonly="readonly" name="{{ $name }}" id="{{ $name }}"
              class="{{ $class }}">{{ $value }}</textarea>
@else
    <textarea rows="{{ $rows }}" cols="{{ $cols }}" name="{{ $name }}" id="{{ $name }}"
              class="{{ $class }}" @if(isset($onkeyup)) onkeyup="{{ $onkeyup }}" @endif>{{ $value }}</textarea>
    @if($errors->has('{{ $name }}')) {!!  $errors->first('{{ $name }}','<p class="text-danger"> :message </p>')  !!} @endif
@endif

