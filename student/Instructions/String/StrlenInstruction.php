<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Variable;

class StrlenInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$variable, $operand1] = $this->getCheckedArgs();

        $result = strlen($operand1->getValue());
        
        $variable->setValue($result, DataType::Int);
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();

        if (count($args) != 2) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        $variable = $this->getDestVar($args[0]);
        
        $arg1 = $this->getArgValue($args[1], DataType::String);


        return [$variable, $arg1];
    }

}