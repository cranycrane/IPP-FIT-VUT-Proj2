<?php

namespace IPP\Student\Factory;

use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Arguments\TypeArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\OpcodeNotFoundException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\DataType;

class ArgumentFactory {
    
    public static function createArg(string $type, $value) {
        if (\in_array($type, ['int', 'nil', 'bool', 'float'])) {
            return new ConstArgument(DataType::from($type), $value);
        }
        else if ($type == 'string') {
            return new ConstArgument(DataType::String, self::convertEscapeSeq($value));
        }
        else if ($type == 'var') {
            return new VarArgument($value);
        }
        else if ($type == 'label') {
            return new LabelArgument($value);
        }
        else if ($type == 'type') {
            return new TypeArgument($value);
        }
    }

    protected static function convertEscapeSeq($string) {
        return preg_replace_callback('/\\\\(\d{1,3})/', function ($matches) {
            $asciiValue = $matches[1];
            if ($asciiValue >= 0 && $asciiValue <= 999) {
                return chr($asciiValue);
            }
            return $matches[0];
        }, $string);
    }

}
