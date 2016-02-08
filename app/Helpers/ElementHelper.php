<?php

/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ElementHelper {

    public static function inputDefaults(Array $args = array()) {
        if (!array_key_exists('class', $args)) {
            $args['class'] = 'form-control';
        } else {
            if (! stristr($args['class'], 'col-')) {
                if (! stristr($args['class'], 'form-control')) {
                    $args['class'] .= ' form-control';
                }
            }
        }
        if (!array_key_exists('type', $args)) {
            $args['type'] = 'text';
        }
        if (!array_key_exists('label', $args)) {
            $args['label'] = false;
        }
        if (!array_key_exists('readonly', $args)) {
            $args['readonly'] = false;
        }

        return $args;
    }

    public static function inputTextReadOnly(Array $args = array()) {
        $argsNew = self::inputDefaults($args);
        $argsNew['readonly'] = true;

        return $argsNew;
    }

    public static function textarea(Array $args = array(), $rows=1, $cols=30) {
        $argsNew = self::inputDefaults($args);
        $argsNew['type'] = 'textarea';
        $argsNew['rows'] = $rows;
        $argsNew['cols'] = $cols;

        return $argsNew;
    }

    public static function checkbox(Array $args = array()) {
        $argsNew = self::inputDefaults($args);
        $argsNew['type'] = 'checkbox';
        if ($argsNew['value'] == 1) {
            $argsNew['checked'] = 'checked';
        }
        $argsNew['value'] = 1;

        return $argsNew;
    }

    public static function checkboxReadOnly(Array $args = array()) {
        $argsNew = self::checkbox($args);
        $argsNew['readonly'] = true;

        return $argsNew;
    }

    public static function getEnumValueList($tableName='', $column='') {
      $type = DB::select( DB::raw("SHOW COLUMNS FROM ".$tableName." WHERE Field = '{$column}'") )[0]->Type;
      preg_match('/^enum\((.*)\)$/', $type, $matches);
      $enum = array();
      foreach( explode(',', $matches[1]) as $value )
      {
        $v = trim( $value, "'" );
        $enum = array_add($enum, $v, $v);
      }
      return $enum;
    }

}
?>
