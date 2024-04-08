<?php

namespace IPP\Student\Factory;

use IPP\Student\Arguments\Argument;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Arguments\TypeArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Enums\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\StringException;

class ArgumentFactory {
    
    public static function createArg(string $type, string $value): Argument {
        if (\in_array($type, ['int', 'nil', 'float'])) {
            return new ConstArgument(DataType::from($type), $value);
        }
        else if ($type == 'bool') {
            $boolValue = strtolower($value) === 'true';
            return new ConstArgument(DataType::Bool, $boolValue);
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
        else {
            throw new ArgumentException();
        }
    }

    protected static function convertEscapeSeq(string $string): string {
        $convertedStr = preg_replace_callback('/\\\\(\d{1,3})/', function ($matches) {
            $asciiValue = (int)$matches[1];
            if ($asciiValue >= 0 && $asciiValue <= 999) {
                return chr($asciiValue);
            }
            return $matches[0];
        }, $string);

        if (!isset($convertedStr)) {
            throw new StringException();
        }
        return $convertedStr;
    }

}
