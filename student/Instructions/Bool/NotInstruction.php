<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;

class NotInstruction extends BoolInstruction {

    public function executeSpecific(): void {
        [$variable, $value] = $this->getCheckedArgs();

        $result = !$value;

        $variable->setValue($result, DataType::Bool); 
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();

        if (count($args) != 2) {
            throw new ArgumentCountError("Nesprávný počet argumentů pro NOT");
        }

        $variable = $this->getDestVar($args[0]);

        $value = $this->getValue($args[1]);

        return [$variable, $value];
    }
}