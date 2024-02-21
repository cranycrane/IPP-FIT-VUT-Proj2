<?php

namespace IPP\Student\Instructions\String;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\StringException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Variable;

class SetcharInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$variable, $position, $string] = $this->getCheckedArgs();

        if ($variable->getType() != DataType::String) {
            throw new WrongOperandTypesException("Prvni argument ocekavan string");
        }

        if ($position->getValue() >= $variable->getValue() || strlen($string->getValue() == 0)) {
            throw new StringException("Indexace mimo retezec nebo druhy retezec je prazdny");
        }

        $result = $variable->getValue();

        $result[$position->getValue()] = $string->getValue()[0];

        $variable->setValue($result, DataType::String);
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        
        if (count($args) != 3) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        $variable = $this->getDestVar($args[0]);
        
        $arg1 = $this->getArgValue($args[1], DataType::Int);
        $arg2 = $this->getArgValue($args[2], DataType::String);

        return [$variable, $arg1, $arg2];
    }

}