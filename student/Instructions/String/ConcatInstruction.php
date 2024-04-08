<?php

namespace IPP\Student\Instructions\String;

use ArgumentCountError;
use IPP\Student\Enums\DataType;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\Variable;

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