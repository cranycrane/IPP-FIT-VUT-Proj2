<?php

namespace IPP\Student\Instructions\Relational;

use IPP\Student\DataType;

class LtInstruction extends RelationalInstruction {

    public function executeSpecific(): void {
        [$variable, $value1, $value2] = $this->getCheckedArgs();

        $result = $value1 < $value2;

        $variable->setValue($result, DataType::Bool);
    }

}
