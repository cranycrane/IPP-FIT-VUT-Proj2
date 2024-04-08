<?php

namespace IPP\Student\Instructions\Arithmetic;

use IPP\Student\Enums\DataType;
use IPP\Student\Exception\ZeroDivisionException;

class IdivInstruction extends ArithmeticInstruction {


    public function executeSpecific(): void {
        [$dest, $op1, $op2] = $this->getCheckedArgs();

        if ($op2 == 0) {
            throw new ZeroDivisionException("Nelze delit nulou!");
        }

        $result = intdiv($op1,$op2);
        
        $dest->setValue($result, DataType::Int);
    }

}