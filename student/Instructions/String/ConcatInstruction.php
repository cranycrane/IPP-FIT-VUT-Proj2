<?php

namespace IPP\Student\Instructions\String;

use ArgumentCountError;
use Exception;
use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Variable;

class ConcatInstruction extends FrameAwareInstruction {


    protected function executeSpecific(): void {
        [$variable, $operand1, $operand2] = $this->getCheckedArgs();
        $result = $operand1 . $operand2;
        $variable->setValue($result, DataType::String);
    }

    /**
     * @return array{Variable,string,string}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();

        if (count($args) != 3) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        $variable = $this->getDestVar($args[0]);
        
        $arg1 = $this->getArgValue($args[1], DataType::String);
        $arg2 = $this->getArgValue($args[2], DataType::String);

        return [$variable, $arg1->getValue(), $arg2->getValue()];
    }

}