<?php

namespace IPP\Student\Instructions;

use IPP\Student\DataType;

class OrInstruction extends BoolInstruction {

    public function executeSpecific(): void {
        [$variable, $value1, $value2] = $this->getCheckedArgs();

        $result = $value1 || $value2;

        $variable->setValue($result, DataType::Bool);
    }

}
