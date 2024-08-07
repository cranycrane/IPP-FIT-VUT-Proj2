<?php

namespace IPP\Student\Instructions\Relational;

use IPP\Student\Enums\DataType;

class GtInstruction extends RelationalInstruction {

    public function executeSpecific(): void {
        [$variable, $value1, $value2] = $this->getCheckedArgs();

        $result = $value1 > $value2;

        $variable->setValue($result, DataType::Bool);
    }

}
