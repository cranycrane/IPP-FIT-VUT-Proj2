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
        $matchingTypeIndex = array_search($type, array_column(DataType::cases(), "value"));
        if ($matchingTypeIndex === false) {
            throw new UnexpectedArgumentException("Uvedeny datovy typ {$type} neexistuje");
        }

        if (\in_array($type, ['string', 'int', 'nil', 'bool', 'float'])) {
            return new ConstArgument(DataType::from($type), $value);
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

    public static function isValidOpcode(string $opcode) {
        $className = self::getClassNameForOpcode($opcode);
        return class_exists($className);
    }

    private static function getClassNameForOpcode($opcode) {
        // Předpokládejme, že $opcode je vždy velkými písmeny
        return "IPP\\Student\\Instructions\\" . ucfirst(strtolower($opcode)) . "Instruction";
    }
}
