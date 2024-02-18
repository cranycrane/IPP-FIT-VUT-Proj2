<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\StringException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Variable;

class GetcharInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$variable, $string, $position] = $this->getCheckedArgs();

        if ($position >= strlen($string)) {
            throw new StringException("Nelze ziskat znak mimo retezec");
        }

        $result = $string[$position];
        
        $variable->setValue($result, DataType::String);
    }

    /**
     * @return array{Variable,string,int}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();

        if (count($args) != 3) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        $variable = $this->getDestVar($args[0]);
        
        $arg1 = $this->getArgValue($args[1], DataType::String);
        $arg2 = $this->getArgValue($args[2], DataType::Int);

        return [$variable, $arg1->getValue(), $arg2->getValue()];
    }

}