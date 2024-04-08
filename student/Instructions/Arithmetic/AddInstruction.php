<?php

namespace IPP\Student\Instructions\Arithmetic;

use IPP\Student\Enums\DataType;

class AddInstruction extends ArithmeticInstruction {

    public function executeSpecific(): void {
        [$dest, $op1, $op2] = $this->getCheckedArgs();

        $result = $op1 + $op2;
        
        $dest->setValue($result, DataType::Int);
    }

}