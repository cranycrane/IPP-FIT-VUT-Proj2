<?php

namespace IPP\Student\Instructions\String;

use ArgumentCountError;
use IPP\Student\Enums\DataType;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\TypedValue;
use IPP\Student\Values\Variable;

class StrlenInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$variable, $operand1] = $this->getCheckedArgs();

        $result = strlen($operand1->getValue());
        
        $variable->setValue($result, DataType::Int);
    }

    /**
     * @return array{Variable,TypedValue}
     */
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