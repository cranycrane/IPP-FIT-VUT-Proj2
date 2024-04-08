<?php

namespace IPP\Student\Instructions\String;

use ArgumentCountError;
use IPP\Student\Enums\DataType;
use IPP\Student\Exception\StringException;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\Variable;

class GetcharInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$variable, $string, $position] = $this->getCheckedArgs();

        if ($position >= strlen($string) || $position < 0) {
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